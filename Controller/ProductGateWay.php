<?php

class ProductGateWay{
    private PDO  $con;
    public function __construct(Db $database){
        $this->con = $database->getConnection();
    }

    public function getAll():array{
        $qry = "SELECT * FROM product";
        $stmt = $this->con-> query($qry);
        $data = [];
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
               $data[] = $row;
        }

        return $data;
    }

    public function getProduct($id):array{
        $qry = "SELECT * FROM product WHERE id='$id'";
        $stmt = $this->con->query($qry);
        //$data = [];
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
         
        return  $stmt->fetch();
    }

    public function createProduct(array $data):string{
        $qry = "INSERT INTO product(name,price,is_discounted,slug)
                VALUES(:name,:price,:is_discounted,:slug)";
                $stmt = $this->con->prepare($qry);
                $stmt->bindValue("name",$data['name'],PDO::PARAM_STR);
                $stmt->bindValue("price",$data['price'],PDO::PARAM_INT);
                $stmt->bindValue("is_discounted",$data['is_discounted']??0,PDO::PARAM_BOOL);
                $stmt->bindValue("slug",$data['slug'],PDO::PARAM_STR);

            $stmt->execute();
            return $this->con->lastInsertId();

    }


    public function deleteProduct(int $id):string{
         if($this->checkProduct($id)){
             $qry = "DELETE FROM product WHERE id = :id";
             $stmt = $this->con->prepare($qry);
             $stmt->bindValue("id",$id,PDO::PARAM_INT);
             $stmt->execute();

             return "successfully Deleted";
         }
         else{
            return  "Product Does not exist";
         }
    }

    public function checkProduct($id):bool{
        $qry = "SELECT * FROM product WHERE id = :id";
        $stmt = $this->con->prepare($qry);
        $stmt->bindValue("id",$id,PDO::PARAM_INT);
        $stmt->execute();

        $rowCount = $stmt->rowCount();

        if($rowCount == 1){
            return true;
        }
        else{
            return false;
        }
    }
}
?>