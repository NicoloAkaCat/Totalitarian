<?php
    require_once(__DIR__."/../variable_utils.php");
    class Product{
        private $id;
        private $name;
        private $description;
        private $price;
        private $image;
        private $image_alt;
        private $quantity;
        private $score;

        public function getId(): int{
            return $this->id;
        }
        public function getName(): string{
            return $this->name;
        }
        public function getDescription(): string{
            return $this->description;
        }
        public function getPrice(): float{
            return $this->price;
        }
        public function getImage(): string{
            return $this->image;
        }
        public function getImageAlt(): string{
            return $this->image_alt;
        }
        public function getQuantity(): int{
            return $this->quantity;
        }
        public function getScore(): int{
            return $this->score;
        }

        public function __construct(int $id, string $name, string $description, float $price, string $image, string $image_alt, int $quantity, int $score){
            $this->id = $id;
            $this->name = $name;
            $this->description = $description;
            $this->price = $price;
            $this->image = "/Totalitarian/src/assets/img/".$image;
            $this->image_alt = $image_alt;
            $this->quantity = $quantity;
            $this->score = $score;
        }

        public static function withRow(?array $row): ?Product{
            if($row == null || !$row)
                return null;
            return new Product($row["id"], $row["name"], $row["description"], $row["price"], $row["img"], $row["img_alt"], $row["quantity"], $row["score"]);
        }
    }
?>