<?php

namespace SymfonyBlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Product
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="SymfonyBlogBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_added", type="datetime")
     */
    private $dateAdded;

    /**
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="product_name", type="string", length=255)
     */
    private $productName;

    /**
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="product_type", type="string", length=255)
     */
    private $productType;

    /**
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="make", type="string", length=255)
     */
    private $make;

    /**
     * @Assert\NotNull()
     * @Assert\Regex(
     *     pattern="/^[a-zA-Z0-9-]+$/",
     *     match=true,
     *     message="Use small or big leters, digits and dash only!"
     * )
     *
     * @var string
     *
     * @ORM\Column(name="model", type="string", length=255)
     */
    private $model;

    /**
     *
     * @var string
     *
     * @ORM\Column(name="product_color", type="string", length=255)
     */
    private $productColor;

    /**
     *
     * @var int
     *
     * @ORM\Column(name="product_weight", type="integer")
     */
    private $productWeight;

    /**
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=10, scale=2)
     */
    private $price;

    /**
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     *      minMessage = "Quantity must be at least 0 to be valid",
     *      maxMessage = "Quantity cannot be bigger than 100 to be valid"
     * )
     *
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var bool
     *
     * @ORM\Column(name="isNew", type="boolean")
     */
    private $isNew;

    /**
     * @Assert\NotNull()
     * @Assert\Choice(
     *     choices={"Asia", "Africa", "North America", "South America", "Antarctica", "Europe", "Oceania"},
     *     message="Choose a valid continent."
     * )
     *
     * @var string
     *
     * @ORM\Column(name="productLocationContinent", type="string", length=255)
     */
    private $productLocationContinent;

    /**
     * @Assert\NotBlank()
     * @var string
     *
     * @ORM\Column(name="productLocationCountry", type="string", length=255)
     */
    private $productLocationCountry;

    /**
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Your description must be at least 4 characters long",
     * )
     *
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @Assert\Url(
     *    message = "The url '{{ value }}' is not a valid url",
     *     protocols = {"http", "https", "ftp"}
     * )
     *
     * @var string
     *
     * @ORM\Column(name="imageUrl", type="string")
     */
    private $imageUrl;

    /**
     * @var int
     *
     * @ORM\Column(name="author_id", type="integer")
     */
    private $authorId;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="SymfonyBlogBundle\Entity\User", inversedBy="products")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id")
     */
    private $author;

    public function __construct()
    {
        $this->dateAdded = new \DateTime('now');
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set make
     *
     * @param string $make
     *
     * @return Product
     */
    public function setMake($make)
    {
        $this->make = $make;

        return $this;
    }

    /**
     * Get make
     *
     * @return string
     */
    public function getMake()
    {
        return $this->make;
    }

    /**
     * Set model
     *
     * @param string $model
     *
     * @return Product
     */
    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    /**
     * Get model
     *
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set isNew
     *
     * @param boolean $isNew
     *
     * @return Product
     */
    public function setIsNew($isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    /**
     * Get isNew
     *
     * @return bool
     */
    public function getIsNew()
    {
        return $this->isNew;
    }

    /**
     * Set productLocation
     *
     * @param string $productLocationContinent
     *
     * @return Product
     */
    public function setProductLocationContinent($productLocationContinent)
    {
        $this->productLocationContinent = $productLocationContinent;

        return $this;
    }

    /**
     * Get productLocation
     *
     * @return string
     */
    public function getProductLocationContinent()
    {
        return $this->productLocationContinent;
    }

    /**
     * @return string
     */
    public function getProductLocationCountry()
    {
        return $this->productLocationCountry;
    }

    /**
     * @param string $productLocationCountry
     */
    public function setProductLocationCountry($productLocationCountry)
    {
        $this->productLocationCountry = $productLocationCountry;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     *
     * @return Product
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     * @return Product
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductType()
    {
        return $this->productType;
    }

    /**
     * @param string $productType
     * @return Product
     */
    public function setProductType($productType)
    {
        $this->productType = $productType;

        return $this;
    }

    /**
     * @return string
     */
    public function getProductColor()
    {
        return $this->productColor;
    }

    /**
     * @param string $productColor
     *
     * @return Product
     */
    public function setProductColor($productColor)
    {
        $this->productColor = $productColor;

        return $this;
    }

    /**
     * @return int
     */
    public function getProductWeight()
    {
        return $this->productWeight;
    }

    /**
     * @param int $productWeight
     *
     * @return Product
     */
    public function setProductWeight($productWeight)
    {
        $this->productWeight = $productWeight;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * @param \DateTime $dateAdded
     * @return Product
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * @return int
     */
    public function getAuthorId()
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     *
     * @return Product
     */
    public function setAuthorId($authorId)
    {
        $this->authorId = $authorId;

        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Product
     */
    public function setAuthor(User $author = null)
    {
        $this->author = $author;

        return $this;
    }



}

