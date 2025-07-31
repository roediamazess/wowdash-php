<?php
// Database configuration for SQLite
$database_path = __DIR__ . '/../database/power_pro_dashboard.db';

// Create database directory if it doesn't exist
$database_dir = dirname($database_path);
if (!is_dir($database_dir)) {
    mkdir($database_dir, 0755, true);
}

try {
    // Create PDO connection to SQLite
    $pdo = new PDO("sqlite:" . $database_path);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Create a mysqli-like wrapper for compatibility with existing code
    $conn = new class($pdo) {
        private $pdo;
        
        public function __construct($pdo) {
            $this->pdo = $pdo;
        }
        
        public function prepare($sql) {
            // Convert MySQL syntax to SQLite
            $sql = str_replace('AUTO_INCREMENT', 'AUTOINCREMENT', $sql);
            $stmt = $this->pdo->prepare($sql);
            
            // Create a wrapper for the statement to mimic mysqli behavior
            return new class($stmt) {
                private $stmt;
                private $params = [];
                
                public function __construct($stmt) {
                    $this->stmt = $stmt;
                }
                
                public function bind_param($types, ...$params) {
                    $this->params = $params;
                    return true;
                }
                
                public function execute() {
                    return $this->stmt->execute($this->params);
                }
                
                public function get_result() {
                    $this->stmt->execute($this->params);
                    return new class($this->stmt) {
                        private $stmt;
                        
                        public function __construct($stmt) {
                            $this->stmt = $stmt;
                        }
                        
                        public function fetch_assoc() {
                            return $this->stmt->fetch(PDO::FETCH_ASSOC);
                        }
                        
                        public function __get($property) {
                            if ($property === 'num_rows') {
                                return $this->stmt->rowCount();
                            }
                            return null;
                        }
                    };
                }
                
                public function close() {
                    $this->stmt = null;
                }
                
                public function fetch_assoc() {
                    return $this->stmt->fetch(PDO::FETCH_ASSOC);
                }
                
                public function __get($property) {
                    if ($property === 'num_rows') {
                        return $this->stmt->rowCount();
                    }
                    return null;
                }
            };
        }
        
        public function query($sql) {
            // Convert MySQL syntax to SQLite
            $sql = str_replace('AUTO_INCREMENT', 'AUTOINCREMENT', $sql);
            $result = $this->pdo->query($sql);
            
            if ($result) {
                // Create a wrapper for the result to mimic mysqli behavior
                return new class($result) {
                    private $result;
                    private $rows = [];
                    private $current_index = 0;
                    
                    public function __construct($result) {
                        $this->result = $result;
                        // Pre-fetch all rows to count them
                        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                            $this->rows[] = $row;
                        }
                    }
                    
                    public function fetch_assoc() {
                        if ($this->current_index < count($this->rows)) {
                            return $this->rows[$this->current_index++];
                        }
                        return false;
                    }
                    
                    public function __get($property) {
                        if ($property === 'num_rows') {
                            return count($this->rows);
                        }
                        return null;
                    }
                };
            }
            return $result;
        }
        
        public function real_escape_string($string) {
            return str_replace("'", "''", $string);
        }
        
        public function set_charset($charset) {
            // SQLite doesn't need charset setting
            return true;
        }
        
        public function close() {
            $this->pdo = null;
        }
        
        public function select_db($database) {
            // SQLite doesn't use database selection
            return true;
        }
        
        public function __get($property) {
            if ($property === 'error') {
                $error = $this->pdo->errorInfo();
                return $error[2] ?? '';
            }
            return null;
        }
    };
    
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>