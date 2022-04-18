<?php

    require_once 'conn.php';

    if(isset($_GET['key'])){
        $key = $_GET['key'];
        $query = "Select * from book where BookTitle like '%$key%'";
        $result = mysqli_query($conn, $query);
        $response = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($response,
                array(
                    'ISBN'=>$row['ISBN'],
                    'BookTitle'=>$row['BookTitle'],
                    'Author'=>$row['Author'],
                    'DescBook'=>$row['DescBook'],
                    'Stock'=>$row['Stock'],
                    'BookCoverPic'=>$row['BookCoverPic']
                ));
            }
            echo json_encode($response);
    }else{
        $query = "Select * from book";
        $result = mysqli_query($conn, $query);
        $response = array();
            while($row = mysqli_fetch_assoc($result)){
                array_push($response,
                array(
                    'ISBN'=>$row['ISBN'],
                    'BookTitle'=>$row['BookTitle'],
                    'Author'=>$row['Author'],
                    'DescBook'=>$row['DescBook'],
                    'Stock'=>$row['Stock'],
                    'BookCoverPic'=>$row['BookCoverPic'])
                );
            }
            echo json_encode($response);
    }

    mysqli_close($conn);

?>
