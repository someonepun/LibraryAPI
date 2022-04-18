<?php
    //to organize all the CRUD operations
    //class DbOperations


    class DbOperations{
        private $con;

        //constructor 
        function __construct(){

            //dirname gives the directory location link
            require_once dirname(__FILE__). '/DbConnect.php';
            
            //creating object of DbConnect class.
            $db = new DbConnect;

            //store the connect in con variable 
            //connect() method from DbConnect.
            $this->con = $db->connect();
        }
  
        //for create operation
        public function createUser($name,$email,$londonID,$password){
            //check if the email is already exist or not
            if(!$this->isEmailExist($email)){
                //prepared statement
                $stmt = $this->con->prepare("INSERT INTO users (name,email,LondonMetID,password) values (?,?,?,?)");
                //data binding bind_param(param1, param2)
                //bind_param(data type, actual data)
                //'s' for string
                $stmt->bind_param("ssss",$name, $email,$londonID, $password);
                if($stmt->execute()){
                    return USER_CREATED;
                }else{
                    return USER_FAILURE;
                }    
            }
            return USER_EXISTS;
        }

        //for book request or borrow book request 
        public function requestBook($id,$name,$isbn,$bookTitle,$bookAuthor){
            //check if book has stock or not
            //checking if requested book is in stock or not and
            //checking whether or not user has book taken previously or not
            if(!$this->isBookInStock($isbn)>0 && isUserHasBookSpace($available)>0){
                $stmt = $this->con->prepare("INSERT INTO bookRequest(id,name,isbn,bookTitle,bookAuthor) VALUES (?,?,?,?,?)");
                $stmt->bind_param("issss", $id, $name, $isbn, $bookTitle,$bookAuthor);
                if($stmt->execute()){
                    return USER_CREATED;
                }else{
                    return USER_FAILURE;
                }
            }return USER_EXISTS;
        }

        //for login user GET request
        public function userLogin($email,$password){
            if($this->isEmailExist($email)){
                $hashed_password = $this->getUsersPasswordByEmail($email);
                if(password_verify($password, $hashed_password)){
                    return USER_AUTHENTICATED;
                }else{
                    return USER_PASSWORD_DO_NOT_MATCH;
                }
            }else{
                return USER_NOT_FOUND;
            }
        }

        //this will authenticate the user
        private function getUsersPasswordByEmail($email){
            $stmt = $this->con->prepare("select password from users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt-> execute();
            $stmt->bind_result($password);
            $stmt->fetch();
            return $password;
        }

        //return the user
        public function getUserByEmail($email){
            $stmt = $this->con->prepare("select id, name, email from users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt-> execute();
            $stmt->bind_result($id,$name,$email);
            $stmt->fetch();
            $user= array();
            $user['id'] = $id;
            $user['name']= $name;
            $user['email'] = $email;
            return $user;
        }

        //checking email already exit or not
        private function isEmailExist($email){
            $stmt = $this->con->prepare("SELECT id FROM users WHERE email=?");
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result(); //if it returns 1 row that means email already exists
            return $stmt->num_rows>0;
        }

        //checking if book is available or not in stock
        private function isBookInStock($ISBN){
            $stmt = $this->con->prepare("SELECT Stock FROM book WHERE ISBN=?");
            $stmt->bind_param("s", $ISBN);
            $stmt-> execute();
            $stmt->bind_result($Stock);
            $stmt->fetch();
            return $Stock;
        }
        
        //User has space for book taking or not
        private function isUserHasBookSpace($id){
            $stmt = $this->con->prepare("SELECT available FROM users WHERE id=?");
            $stmt->bind_param("i", $id);
            $stmt-> execute();
            $stmt->bind_result($Available);
            $stmt->fetch();
            return $Available;
        }
        //to get all the users.
        public function getAllUsers(){
            $stmt = $this->con->prepare("SELECT id, email FROM users;");
            $stmt->execute(); 
            $stmt->bind_result($id, $email);
            $users = array(); //array name $users to store all the users
            //to fetch all available users from database
            while($stmt->fetch()){ 
                $user = array(); 
                $user['id'] = $id; 
                $user['email']=$email; 
                array_push($users, $user);
            }             
            return $users; 
        }

        //trying GET
        //toget all the books informations
        public function getAllBooksInfo($key){
        //     $CONST = "ALL"; 
        //     if($key!= $CONST){
        //         $stmt = $this->con->prepare("SELECT * FROM book where BookTitle like '%$key%';");
        //         $stmt->execute(); 
        //         $stmt->bind_result($isbn, $bookTitle, $author, $decBook, $stock, $bookCoverPic);
        //         $books = array(); //array name $books to store all the users
        //         //to fetch all available books info from database
        //         while($stmt->fetch()){ 
        //             $book = array(); 
        //             $book['ISBN'] = $isbn; 
        //             $book['BookTitle']=$bookTitle;
        //             $book['Author'] = $author;
        //             $book['DescBook'] = $decBook;
        //             $book['Stock'] = $stock;
        //             $book['BookCoverPic'] = $bookCoverPic;
        //             array_push($books, $book);
        //     }             
        //     return $books; 
        // }else if($key==$CONST){  
        //     $key=$CONST;
        //     $stmt = $this->con->prepare("SELECT * FROM book;");
        //     $stmt->execute(); 
        //     $stmt->bind_result($isbn, $bookTitle, $author, $decBook, $stock, $bookCoverPic);
        //     $books = array(); //array name $books to store all the users
        //     //to fetch all available books info from database
        //     while($stmt->fetch()){ 
        //         $book = array(); 
        //         $book['ISBN'] = $isbn; 
        //         $book['BookTitle']=$bookTitle;
        //         $book['Author'] = $author;
        //         $book['DescBook'] = $decBook;
        //         $book['Stock'] = $stock;
        //         $book['BookCoverPic'] = $bookCoverPic;
        //         array_push($books, $book);
        //     }             
        //     return $books; 
        // }
        $CONST = "ALL"; 
            if($key!= $CONST){
                $stmt = $this->con->prepare("SELECT * FROM book where BookTitle like '%$key%';");
                $stmt->execute(); 
                $stmt->bind_result($isbn, $bookTitle, $author, $decBook, $stock, $bookCoverPic);
                $books = array(); //array name $books to store all the users
                //to fetch all available books info from database
                while($stmt->fetch()){ 
                    $book = array(); 
                    $book['ISBN'] = $isbn; 
                    $book['BookTitle']=$bookTitle;
                    $book['Author'] = $author;
                    $book['DescBook'] = $decBook;
                    $book['Stock'] = $stock;
                    $book['BookCoverPic'] = $bookCoverPic;
                    array_push($books, $book);
            }             
            return $books; 
        }else if($key==$CONST){  
            $stmt = $this->con->prepare("SELECT * FROM book;");
            $stmt->execute(); 
            $stmt->bind_result($isbn, $bookTitle, $author, $decBook, $stock, $bookCoverPic);
            $books = array(); //array name $books to store all the users
            //to fetch all available books info from database
            while($stmt->fetch()){ 
                $book = array(); 
                $book['ISBN'] = $isbn; 
                $book['BookTitle']=$bookTitle;
                $book['Author'] = $author;
                $book['DescBook'] = $decBook;
                $book['Stock'] = $stock;
                $book['BookCoverPic'] = $bookCoverPic;
                array_push($books, $book);
            }             
            return $books; 
            }   
        }

        //trying GET
        //Search statements
        public function getAllBooksInfoSearch($key){
            $stmt = $this->con->prepare("SELECT * FROM book where BookTitle like '%$key%';");
            $stmt->execute(); 
            $stmt->bind_result($isbn, $bookTitle, $author, $decBook, $stock, $bookCoverPic);
            $books = array(); //array name $books to store all the users
            //to fetch all available books info from database
            while($stmt->fetch()){ 
                $book = array(); 
                $book['ISBN'] = $isbn; 
                $book['BookTitle']=$bookTitle;
                $book['Author'] = $author;
                $book['DescBook'] = $decBook;
                $book['Stock'] = $stock;
                $book['BookCoverPic'] = $bookCoverPic;
                array_push($books, $book);
            }             
            return $books; 
        }

        //to update user
        public function updateUser($name,$email,$id){
            $stmt = $this->con->prepare("update users set name= ?,email=? where id=?");
            $stmt->bind_param("ssi", $name, $email, $id);
            if($stmt->execute())
                return true; 
            return false;
        }

        //to update password
        public function updatePassword($currentpassword,$newpassword,$email){
            $hashed_password =$this->getUsersPasswordByEmail($email);

            if(password_verify($currentpassword, $hashed_password)){
                $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);
                $stmt = $this->con->prepare("UPDATE users SET password=? where email=?");
                $stmt->bind_param("ss",$hashed_password, $email);
                
                if($stmt->execute()){
                    return PASSWORD_CHANGED;
                }else{
                    return PASSWORD_NOT_CHANGED;
                }
            }else{
                return PASSWORD_DO_NOT_MATCH;
            }
        }

        //to delete users
        public function deleteUser($id){
            $stmt = $this->con->prepare("Delete from users where id= ?");
            $stmt->bind_param("i", $id);
            if($stmt->execute()){
                return true;
            }else{
                return false;
            }
        }
    }