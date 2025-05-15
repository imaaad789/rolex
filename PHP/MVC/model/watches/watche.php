<?php

    class Create_Table_Watche {
        private $conn;
        private $watche = [
            ['full_name' => 'Rolex Submariner Date', 'module' => 'Submariner', 'refer' => '126610LN', 'Quantite' => 17, 'price' => 10500],
            ['full_name' => 'Rolex Daytona Cosmograph', 'module' => 'Daytona', 'refer' => '116500LN', 'Quantite' => 20, 'price' => 29500],
            ['full_name' => 'Rolex GMT-Master II Pepsi', 'module' => 'GMT-Master II', 'refer' => '126710BLRO', 'Quantite' => 12, 'price' => 14500],
            ['full_name' => 'Rolex Datejust 41', 'module' => 'Datejust', 'refer' => '126334', 'Quantite' => 30, 'price' => 9500],
            ['full_name' => 'Rolex Day-Date President', 'module' => 'Day-Date', 'refer' => '228238', 'Quantite' => 24, 'price' => 37000],
            ['full_name' => 'Rolex Explorer I', 'module' => 'Explorer', 'refer' => '124270', 'Quantite' => 45, 'price' => 7500],
            ['full_name' => 'Rolex Milgauss', 'module' => 'Milgauss', 'refer' => '116400GV', 'Quantite' => 18, 'price' => 8800],
            ['full_name' => 'Rolex Sea-Dweller', 'module' => 'Sea-Dweller', 'refer' => '126600', 'Quantite' => 32, 'price' => 13000],
            ['full_name' => 'Rolex Yacht-Master II', 'module' => 'Yacht-Master II', 'refer' => '116680', 'Quantite' => 10, 'price' => 18500],
            ['full_name' => 'Rolex Air-King', 'module' => 'Air-King', 'refer' => '126900', 'Quantite' => 38, 'price' => 7200],
        ];

        public function __construct($conn) {
            $this->conn = $conn;
            $this->Create_Table();
            $this->Insert_Info_watch();
        }

        public function Create_Table() {
            try {
                $sql = "CREATE TABLE IF NOT EXISTS watches (
                    id INT AUTO_INCREMENT PRIMARY KEY,
                    full_name VARCHAR(100) NOT NULL,
                    model VARCHAR(100) NOT NULL,
                    reference_number VARCHAR(50) NOT NULL UNIQUE,
                    Quantite INT NOT NULL,
                    price DECIMAL(10,2) NOT NULL,
                    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
                )";
                $this->conn->exec($sql);
                return true;
            } catch (PDOException $e) {
                throw new Exception("Error creating table: " . $e->getMessage());
            }
        }

        public function Insert_Info_watch() {
            try {
                // Check if the table is empty
                $stmt = $this->conn->query("SELECT COUNT(*) as count FROM watches");
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                // If table is not empty, check for existing references
                if ($result['count'] > 0) {
                    foreach ($this->watche as $watch) {
                        $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM watches WHERE reference_number = ?");
                        $stmt->execute([$watch['refer']]);
                        $exists = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

                        if ($exists == 0) {
                            $sql = "INSERT INTO watches (full_name, model, reference_number, Quantite, price) VALUES (?, ?, ?, ?, ?)";
                            $stmt = $this->conn->prepare($sql);
                            $stmt->execute([
                                $watch['full_name'],
                                $watch['module'],
                                $watch['refer'],
                                $watch['Quantite'],
                                $watch['price']
                            ]);
                        }
                    }
                } else {
                    // If table is empty, insert all watches
                    foreach ($this->watche as $watch) {
                        $sql = "INSERT INTO watches (full_name, model, reference_number, Quantite, price) VALUES (?, ?, ?, ?, ?)";
                        $stmt = $this->conn->prepare($sql);
                        $stmt->execute([
                            $watch['full_name'],
                            $watch['module'],
                            $watch['refer'],
                            $watch['Quantite'],
                            $watch['price']
                        ]);
                    }
                }
                return true;
            } catch (PDOException $e) {
                throw new Exception("Error inserting watch data: " . $e->getMessage());
            }
        }

        public function deleteWatch($reference_number) {
            try {
                // Check if the watch exists
                $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM watches WHERE reference_number = ?");
                $stmt->execute([$reference_number]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] == 0) {
                    return "No watch found with reference number: $reference_number";
                }

                // Delete the watch
                $sql = "DELETE FROM watches WHERE reference_number = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([$reference_number]);

                return "Watch with reference number $reference_number deleted successfully!";
            } catch (PDOException $e) {
                throw new Exception("Error deleting watch: " . $e->getMessage());
            }
        }

        public function updateWatch($reference_number, $full_name, $model, $Quantite, $price) {
            try {
                // Check if the watch exists
                $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM watches WHERE reference_number = ?");
                $stmt->execute([$reference_number]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] == 0) {
                    return "No watch found with reference number: $reference_number";
                }

                // Update the watch
                $sql = "UPDATE watches SET full_name = ?, model = ?, Quantite = ?, price = ? WHERE reference_number = ?";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    $full_name,
                    $model,
                    $Quantite,
                    $price,
                    $reference_number
                ]);

                return "Watch with reference number $reference_number updated successfully!";
            } catch (PDOException $e) {
                throw new Exception("Error updating watch: " . $e->getMessage());
            }
        }


        public function addWatch($full_name, $reference_number, $Quantite, $model = "Unknown", $price = 0.00) {
            try {
                // Check if reference_number already exists
                $stmt = $this->conn->prepare("SELECT COUNT(*) as count FROM watches WHERE reference_number = ?");
                $stmt->execute([$reference_number]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($result['count'] > 0) {
                    return "Watch with reference number $reference_number already exists!";
                }

                // Insert the new watch
                $sql = "INSERT INTO watches (full_name, model, reference_number, Quantite, price) VALUES (?, ?, ?, ?, ?)";
                $stmt = $this->conn->prepare($sql);
                $stmt->execute([
                    $full_name,
                    $model,
                    $reference_number,
                    $Quantite,
                    $price
                ]);

                return "Watch '$full_name' with reference $reference_number added successfully!";
            } catch (PDOException $e) {
                throw new Exception("Error adding watch: " . $e->getMessage());
            }
        }
    }

?>