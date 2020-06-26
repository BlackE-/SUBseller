<?php
    class DB{
        private $db_host;
        private $username;
        private $pwd;
        private $database;
        private $connection;
        public $error_message = '';


        
        function __construct(){
            $array_ini = parse_ini_file('setup.ini', true);
            $this->InitDB(
                $array_ini['host'],
                $array_ini['username'],
                $array_ini['pwd'],
                $array_ini['database']);
            // $this->DBLogin();
        }

        //-----Initialization -------
        function InitDB($host,$uname,$pwd,$database){
            $this->db_host  = $host;
            $this->username = $uname;
            $this->pwd  = $pwd;
            $this->database  = $database;

        }

        function CloseAll(){
            mysqli_close($this->connection);
        }
        

        //-------   FUNCIONES GLOBALES   ----------------------
        //  UTIL FUNCTIONS
        function DBLogin(){
            $returnValue = true;
            try{
                $this->connection = mysqli_connect($this->db_host,$this->username,$this->pwd,$this->database);
                if(!$this->connection){ 
                    $this->HandleError("Database Login failed!");
                    $returnValue = false;
                }else{
                    if(!mysqli_query($this->connection,"SET NAMES 'UTF8'")){
                        $this->HandleDBError('Error setting utf8 encoding');
                        $returnValue = false;
                    }
                }
            }
            catch(Exception $e){
                 $this->HandleDBError($e->getMessage());
                 $returnValue = false;
            }
            return $returnValue;
        }

        function selectQuery($select){
            $result = mysqli_query($this->connection,$select);
            if(!$result){
                return false;
            }
            return $result;
        }
        function insertQuery($insert){
            $returnValue = true;
            $this->HandleError('Insert Correct');
            $result = mysqli_query($this->connection,$insert);
            if(!$result){
                if (mysqli_errno($this->connection) == 1062) {
                    $this->HandleError('Dato duplicado');
                }
                else{
                    $this->HandleDBError('No insert'.$insert);
                }
                $returnValue = false;
            }
            return $returnValue;
        }
        function updateQuery($update){
            $result = mysqli_query($this->connection,$update);
            if(!$result){
                return false;
            }
            return true;
        }
        function deleteQuery($delete){
            $result = mysqli_query($this->connection,$delete);
            if(!$result){
                return false;
            }
            return true;
        }
        function fetchAssoc($result){
            $return = mysqli_fetch_array($result,MYSQLI_ASSOC);return $return;
        }
        function fetchArray($result){
            $return = mysqli_fetch_array($result);return $return;
        }
        
        function numRows($result){
            if(mysqli_num_rows($result)<=0){return false;}
            else{return true;}
        }
        
        function lastInsertID(){
            return mysqli_insert_id($this->connection); 
        }
        function HandleError($err)   {      $this->error_message = $err."\r\n";}
        function HandleDBError($err) {      $this->HandleError($err."\r\n mysqlerror:".mysqli_error($this->connection));}
        function GetErrorMessage(){
            if(empty($this->error_message)){return '';}
            $errormsg = nl2br(htmlentities($this->error_message));
            return $errormsg;
        }

        function createTables(){
            $returnValue = true;
            try{
                $create = "CREATE TABLE _user(
                            id_user INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(45),
                            email VARCHAR(45) NOT NULL UNIQUE,
                            _password VARCHAR(255) NOT NULL,
                            type VARCHAR(5),
                            date_created DATETIME DEFAULT CURRENT_TIMESTAMP
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE brand(
                            id_brand INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(45),
                            status BOOLEAN COMMENT '0-HIDDEN 1-SHOW'
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE client(
                            id_client INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            name VARCHAR(45),
                            email VARCHAR(45) NOT NULL UNIQUE,
                            _password VARCHAR(255),
                            sex VARCHAR(1) COMMENT 'F/M',
                            id_facebook VARCHAR(30),
                            date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
                            birthday DATE,
                            id_conekta VARCHAR(21),
                            phone VARCHAR(15),
                            newsletter boolean
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE media(
                            id_media INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                url VARCHAR (150) NOT NULL,
                                type VARCHAR(45) NOT NULL,
                                id_type INT COMMENT 'KEY OF THE ELEMENT (from TYPE) RELATED'
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE tag(
                                id_tag INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(45)
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE category(
                                id_category INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR (45),
                                status BOOLEAN COMMENT '0-SHOW 1-HIDDEN'
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE html_content(
                                id_html_content INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                text TEXT,
                                status BOOLEAN COMMENT '0-show 1-hidden',
                                mobile BOOLEAN COMMENT '0-desktop 1-mobile',
                                type VARCHAR(30) COMMENT '1-BACKGROUND',
                                page VARCHAR(30) COMMENT 'PAGE URL OF HTML CONTENT',
                                id_html_content_parent INT COMMENT 'id_html of PARENT (only mobile has data)'
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE type(
                                id_type INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(30),
                                status BOOLEAN,
                                id_parent INT DEFAULT NULL
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE coupon(
                                id_coupon INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
                                code VARCHAR(20) UNIQUE NOT NULL,
                                description TEXT,
                                discount_type VARCHAR(20) COMMENT 'PERCENTAGE(%),FIXED($),FIXED_PRODUCT($ EACH PRODUCT),PERCENTAGE_PRODUCTS(% EACH PRODUCT),FREE_SHIPPING',
                                amount DECIMAL(10,2),
                                status BOOLEAN,
                                date_expires DATETIME DEFAULT CURRENT_TIMESTAMP,
                                usage_count INT DEFAULT 0,
                                product_ids TEXT COMMENT 'ARRAY OF PRODUCTS INCLUDED TO BE DISCOUNT',
                                product_ids_excluded TEXT COMMENT 'ARRAY OF PRODUCTS NOT INCLUDED IN THE DISCOUNT',
                                used_by TEXT COMMENT 'ARRAY OF CLIENTS WHO HAVE USED THE COUPON'
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE carousel(
                                id_carousel INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(45),
                                status BOOLEAN
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE settings(
                                id_settings INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                name VARCHAR(45),
                                value TEXT,
                                type VARCHAR(50)
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }

                $create = "CREATE TABLE product(
                                id_product INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                sku VARCHAR(50) NOT NULL UNIQUE COMMENT 'UNIQUE CODE FOR PRODUCT',
                                name VARCHAR(45),
                                price_base DECIMAL(10,2) COMMENT 'UNIT PRICE',
                                price_sale DECIMAL(10,2) NOT NULL COMMENT 'PRICE FOR SALE',
                                status BOOLEAN DEFAULT 1,
                                discount DECIMAL(3,2),
                                tax DECIMAL(10,2),
                                unit VARCHAR(5) DEFAULT 'PZA',
                                description_short VARCHAR(45),
                                tiempo_de_uso VARCHAR(10),
                                description TEXT, 
                                fav BOOLEAN DEFAULT 0,
                                out_of_stock BOOLEAN DEFAULT 0,
                                product_related TEXT COMMENT 'ARRAY OF PRODUCTS related TO THIS PRODUCT',
                                brand_id_brand INT UNSIGNED NOT NULL,
                                type_id_type INT UNSIGNED NOT NULL,
                                
                                INDEX (brand_id_brand),
                                INDEX (type_id_type),
                                
                                FOREIGN KEY (brand_id_brand)
                                    REFERENCES brand(id_brand)
                                    ON DELETE NO ACTION ON UPDATE CASCADE,
                                
                                FOREIGN KEY (type_id_type)
                                    REFERENCES type(id_type)
                                    ON DELETE NO ACTION ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                    exit();
                }
                $create = "CREATE TABLE product_tag(
                            id_product_tag INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            product_id_product INT UNSIGNED,
                            tag_id_tag INT UNSIGNED,
                            
                            INDEX(product_id_product),
                            INDEX(tag_id_tag),
                            
                            FOREIGN KEY (product_id_product)
                                REFERENCES product(id_product)
                                ON DELETE NO ACTION ON UPDATE CASCADE,
                           
                            FOREIGN KEY (tag_id_tag)
                                REFERENCES tag(id_tag)
                                ON DELETE NO ACTION ON UPDATE CASCADE   
                        )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE product_category(
                                id_product_category INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                product_id_product INT UNSIGNED,
                                category_id_category INT UNSIGNED,
                                
                                INDEX (category_id_category),
                                INDEX (product_id_product),
                                
                                FOREIGN KEY(product_id_product)
                                    REFERENCES product(id_product)
                                    ON DELETE NO ACTION ON UPDATE CASCADE,
                                FOREIGN KEY(category_id_category)
                                    REFERENCES category(id_category)
                                    ON DELETE NO ACTION ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE product_inventory(
                                id_product_inventory INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                product_id_product INT UNSIGNED,
                                stock INT DEFAULT 0,

                                INDEX (product_id_product),
                                
                                FOREIGN KEY(product_id_product)
                                    REFERENCES product(id_product)
                                    ON DELETE NO ACTION ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE product_movement(
                                id_product_movement INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                product_id_product INT UNSIGNED,
                                date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
                                stock INT,
                                type VARCHAR(20) COMMENT 'INGRESO,EGRESO',

                                INDEX (product_id_product),
                                
                                FOREIGN KEY(product_id_product)
                                    REFERENCES product(id_product)
                                    ON DELETE NO ACTION ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE carousel_slide(
                                id_carousel_slide INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                number_slide INT DEFAULT 1,
                                url VARCHAR(100),
                                text text,
                                carousel_id_carousel INT UNSIGNED,
                                
                                INDEX (carousel_id_carousel),
                                
                                FOREIGN KEY(carousel_id_carousel)
                                    REFERENCES carousel(id_carousel)
                                    ON DELETE CASCADE ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE shipping(
                                id_shipping INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                address_line_1 VARCHAR(50),
                                address_line_2 VARCHAR(50),
                                city VARCHAR(45),
                                cp VARCHAR(6),
                                state VARCHAR(35),
                                country VARCHAR(3) DEFAULT 'MEX' COMMENT 'ISO3 EJ:mxn',
                                notes text,
                                name VARCHAR(45),
                                client_id_client INT UNSIGNED,
                                
                                INDEX(client_id_client),
                                
                                FOREIGN KEY(client_id_client)
                                    REFERENCES client(id_client)
                                    ON DELETE NO ACTION ON UPDATE CASCADE 
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE billing(
                                id_billing INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                address_line_1 VARCHAR(50),
                                address_line_2 VARCHAR(50),
                                cp VARCHAR(6),
                                city VARCHAR(45),
                                state VARCHAR(35),
                                country VARCHAR(3) DEFAULT 'MEX' COMMENT 'ISO3 EJ:MEX',
                                email VARCHAR(45),
                                rfc VARCHAR(20),
                                razon_social VARCHAR(45),
                                cfdi VARCHAR(45),
                                client_id_client INT UNSIGNED,
                                
                                INDEX(client_id_client),
                                
                                FOREIGN KEY(client_id_client)
                                    REFERENCES client(id_client)
                                    ON UPDATE NO ACTION ON DELETE CASCADE 
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE session_client(
                                id_session_client INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                client_id_client INT UNSIGNED,
                                status BOOLEAN,
                                
                                INDEX (client_id_client),
                                
                                FOREIGN KEY(client_id_client)
                                    REFERENCES client(id_client)
                                    ON DELETE NO ACTION ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE session_cart(
                                id_session_cart INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                number_items INT,
                                price DECIMAL(10,2),
                                session_client_id_session_client INT UNSIGNED,
                                product_id_product INT UNSIGNED,
                                
                                INDEX(session_client_id_session_client),
                                INDEX(product_id_product),
                                
                                FOREIGN KEY(session_client_id_session_client)
                                    REFERENCES session_client(id_session_client)
                                    ON DELETE NO ACTION ON UPDATE CASCADE,
                                
                                FOREIGN KEY(product_id_product)
                                    REFERENCES product(id_product)
                                    ON DELETE NO ACTION ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE _order(
                                id_order INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                date_created DATETIME DEFAULT CURRENT_TIMESTAMP,
                                status varchar(15) COMMENT 'PENDING PAYMENT(OXXO,SPEI) / PROCESSING (PAYED) / SEND / CANCELED / REFUNDED / COMPLETE',
                                total float,
                                shipping_fee float,
                                taxes float,
                                cve_order VARCHAR(10) COMMENT 'UNIQUE CODE FOR EACH ORDER',
                                client_id_client INT UNSIGNED,
                                session_client_id_session_client INT UNSIGNED,
                                shipping_id_shipping INT UNSIGNED,
                                billing_id_billing INT UNSIGNED,
                                coupon_id_coupon INT UNSIGNED,
                                
                                INDEX(client_id_client),
                                INDEX(session_client_id_session_client),
                                INDEX(shipping_id_shipping),
                                INDEX(billing_id_billing),
                                INDEX(coupon_id_coupon),
                                
                                FOREIGN KEY(client_id_client)
                                    REFERENCES client(id_client)
                                    ON DELETE RESTRICT ON UPDATE CASCADE,

                                FOREIGN KEY(session_client_id_session_client)
                                    REFERENCES session_client(id_session_client)
                                    ON DELETE RESTRICT ON UPDATE CASCADE,
                                
                                FOREIGN KEY(shipping_id_shipping)
                                    REFERENCES shipping(id_shipping)
                                    ON DELETE RESTRICT ON UPDATE CASCADE,
                                
                                FOREIGN KEY(billing_id_billing)
                                    REFERENCES billing(id_billing)
                                    ON DELETE RESTRICT ON UPDATE CASCADE,

                                FOREIGN KEY(coupon_id_coupon)
                                    REFERENCES coupon(id_coupon)
                                    ON DELETE RESTRICT ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE cart_item(
                                id_cart_item INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                product_id_product INT UNSIGNED,
                                number_items INT, 
                                price DECIMAL (10,2),
                                order_id_order INT UNSIGNED,
                                
                                INDEX (product_id_product),
                                INDEX (order_id_order),
                                
                                FOREIGN KEY(product_id_product)
                                    REFERENCES product(id_product)
                                    ON DELETE RESTRICT ON UPDATE CASCADE,
                                
                                FOREIGN KEY(order_id_order)
                                    REFERENCES _order(id_order)
                                    ON DELETE RESTRICT ON UPDATE CASCADE 
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                $create = "CREATE TABLE _transaction(
                                id_transaction INT UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY,
                                id_conekta VARCHAR(30),
                                code VARCHAR(100) COMMENT 'OXXO REFERENCE / SPEI CLABE / CARD CODE / PAYPAL ID',
                                type VARCHAR(7) COMMENT 'OXXO,SPEI,CARD,PAYPAL',
                                order_id_order INT UNSIGNED,

                                INDEX(order_id_order),
                                
                                FOREIGN KEY(order_id_order)
                                    REFERENCES _order(id_order)
                                    ON DELETE RESTRICT ON UPDATE CASCADE
                            )";
                $result = mysqli_query($this->connection,$create);
                if(!$result){
                    $returnValue = false;
                    $this->HandleDBError('Error creating tables');
                }
                
                return $returnValue;
            }
            catch(Exception $e){
                 $this->HandleDBError("Catch:" . $e->getMessage());
                 $returnValue = false;
            }
        }
    }
?>