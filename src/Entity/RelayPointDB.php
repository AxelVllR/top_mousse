<?php

namespace App\Entity;

use App\Repository\RelayPointDBRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RelayPointDBRepository::class)
 */
class RelayPointDB
{


    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $one;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $two;

    /**
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $three;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $four;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $five;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $six;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seven;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eight;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $ten;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eleven;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twelve;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirteen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fourteen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fifteen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sixteen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $seventeen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $eighteen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $nineteen;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twenty;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentyone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentytwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentythree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentyfour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentyfive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentysix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentyseven;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentyeight;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twentynine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirty;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtyone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtytwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtythree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtyfour;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtyfive;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtysix;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtyseven;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtyeight;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $thirtynine;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $forty;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fortyone;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fortytwo;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fortythree;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fortyfour;


    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getFortythree()
    {
        return $this->fortythree;
    }

    /**
     * @param mixed $fortythree
     */
    public function setFortythree($fortythree): void
    {
        $this->fortythree = $fortythree;
    }

    /**
     * @return mixed
     */
    public function getFortyfour()
    {
        return $this->fortyfour;
    }

    /**
     * @param mixed $fortyfour
     */
    public function setFortyfour($fortyfour): void
    {
        $this->fortyfour = $fortyfour;
    }

    /**
     * @return mixed
     */
    public function getFortytwo()
    {
        return $this->fortytwo;
    }

    /**
     * @param mixed $fortytwo
     */
    public function setFortytwo($fortytwo): void
    {
        $this->fortytwo = $fortytwo;
    }

    /**
     * @return mixed
     */
    public function getFortyone()
    {
        return $this->fortyone;
    }

    /**
     * @param mixed $fortyone
     */
    public function setFortyone($fortyone): void
    {
        $this->fortyone = $fortyone;
    }

    /**
     * @return mixed
     */
    public function getForty()
    {
        return $this->forty;
    }

    /**
     * @param mixed $forty
     */
    public function setForty($forty): void
    {
        $this->forty = $forty;
    }

    /**
     * @return mixed
     */
    public function getThirtynine()
    {
        return $this->thirtynine;
    }

    /**
     * @param mixed $thirtynine
     */
    public function setThirtynine($thirtynine): void
    {
        $this->thirtynine = $thirtynine;
    }

    /**
     * @return mixed
     */
    public function getThirtyeight()
    {
        return $this->thirtyeight;
    }

    /**
     * @param mixed $thirtyeight
     */
    public function setThirtyeight($thirtyeight): void
    {
        $this->thirtyeight = $thirtyeight;
    }

    /**
     * @return mixed
     */
    public function getThirtyseven()
    {
        return $this->thirtyseven;
    }

    /**
     * @param mixed $thirtyseven
     */
    public function setThirtyseven($thirtyseven): void
    {
        $this->thirtyseven = $thirtyseven;
    }

    /**
     * @return mixed
     */
    public function getThirtysix()
    {
        return $this->thirtysix;
    }

    /**
     * @param mixed $thirtysix
     */
    public function setThirtysix($thirtysix): void
    {
        $this->thirtysix = $thirtysix;
    }

    /**
     * @return mixed
     */
    public function getThirtyfive()
    {
        return $this->thirtyfive;
    }

    /**
     * @param mixed $thirtyfive
     */
    public function setThirtyfive($thirtyfive): void
    {
        $this->thirtyfive = $thirtyfive;
    }

    /**
     * @return mixed
     */
    public function getThirtyfour()
    {
        return $this->thirtyfour;
    }

    /**
     * @param mixed $thirtyfour
     */
    public function setThirtyfour($thirtyfour): void
    {
        $this->thirtyfour = $thirtyfour;
    }

    /**
     * @return mixed
     */
    public function getThirtythree()
    {
        return $this->thirtythree;
    }

    /**
     * @param mixed $thirtythree
     */
    public function setThirtythree($thirtythree): void
    {
        $this->thirtythree = $thirtythree;
    }

    /**
     * @return mixed
     */
    public function getThirtytwo()
    {
        return $this->thirtytwo;
    }

    /**
     * @param mixed $thirtytwo
     */
    public function setThirtytwo($thirtytwo): void
    {
        $this->thirtytwo = $thirtytwo;
    }

    /**
     * @return mixed
     */
    public function getThirtyone()
    {
        return $this->thirtyone;
    }

    /**
     * @param mixed $thirtyone
     */
    public function setThirtyone($thirtyone): void
    {
        $this->thirtyone = $thirtyone;
    }

    /**
     * @return mixed
     */
    public function getThirty()
    {
        return $this->thirty;
    }

    /**
     * @param mixed $thirty
     */
    public function setThirty($thirty): void
    {
        $this->thirty = $thirty;
    }

    /**
     * @return mixed
     */
    public function getTwentynine()
    {
        return $this->twentynine;
    }

    /**
     * @param mixed $twentynine
     */
    public function setTwentynine($twentynine): void
    {
        $this->twentynine = $twentynine;
    }

    /**
     * @return mixed
     */
    public function getTwentyeight()
    {
        return $this->twentyeight;
    }

    /**
     * @param mixed $twentyeight
     */
    public function setTwentyeight($twentyeight): void
    {
        $this->twentyeight = $twentyeight;
    }

    /**
     * @return mixed
     */
    public function getTwentyseven()
    {
        return $this->twentyseven;
    }

    /**
     * @param mixed $twentyseven
     */
    public function setTwentyseven($twentyseven): void
    {
        $this->twentyseven = $twentyseven;
    }

    /**
     * @return mixed
     */
    public function getTwentysix()
    {
        return $this->twentysix;
    }

    /**
     * @param mixed $twentysix
     */
    public function setTwentysix($twentysix): void
    {
        $this->twentysix = $twentysix;
    }

    /**
     * @return mixed
     */
    public function getNine()
    {
        return $this->nine;
    }

    /**
     * @param mixed $nine
     */
    public function setNine($nine): void
    {
        $this->nine = $nine;
    }

    /**
     * @return mixed
     */
    public function getFour()
    {
        return $this->four;
    }

    /**
     * @param mixed $four
     */
    public function setFour($four): void
    {
        $this->four = $four;
    }

    /**
     * @return mixed
     */
    public function getTwentyone()
    {
        return $this->twentyone;
    }

    /**
     * @param mixed $twentyone
     */
    public function setTwentyone($twentyone): void
    {
        $this->twentyone = $twentyone;
    }

    /**
     * @return mixed
     */
    public function getTwentyfive()
    {
        return $this->twentyfive;
    }

    /**
     * @param mixed $twentyfive
     */
    public function setTwentyfive($twentyfive): void
    {
        $this->twentyfive = $twentyfive;
    }

    /**
     * @return mixed
     */
    public function getTwenty()
    {
        return $this->twenty;
    }

    /**
     * @param mixed $twenty
     */
    public function setTwenty($twenty): void
    {
        $this->twenty = $twenty;
    }

    /**
     * @return mixed
     */
    public function getTwentyfour()
    {
        return $this->twentyfour;
    }

    /**
     * @param mixed $twentyfour
     */
    public function setTwentyfour($twentyfour): void
    {
        $this->twentyfour = $twentyfour;
    }

    /**
     * @return mixed
     */
    public function getOne()
    {
        return $this->one;
    }

    /**
     * @param mixed $one
     */
    public function setOne($one): void
    {
        $this->one = $one;
    }

    /**
     * @return mixed
     */
    public function getFourteen()
    {
        return $this->fourteen;
    }

    /**
     * @param mixed $fourteen
     */
    public function setFourteen($fourteen): void
    {
        $this->fourteen = $fourteen;
    }

    /**
     * @return mixed
     */
    public function getTwo()
    {
        return $this->two;
    }

    /**
     * @param mixed $two
     */
    public function setTwo($two): void
    {
        $this->two = $two;
    }

    /**
     * @return mixed
     */
    public function getThree()
    {
        return $this->three;
    }

    /**
     * @param mixed $three
     */
    public function setThree($three): void
    {
        $this->three = $three;
    }

    /**
     * @return mixed
     */
    public function getEighteen()
    {
        return $this->eighteen;
    }

    /**
     * @param mixed $eighteen
     */
    public function setEighteen($eighteen): void
    {
        $this->eighteen = $eighteen;
    }

    /**
     * @return mixed
     */
    public function getFive()
    {
        return $this->five;
    }

    /**
     * @param mixed $five
     */
    public function setFive($five): void
    {
        $this->five = $five;
    }

    /**
     * @return mixed
     */
    public function getNineteen()
    {
        return $this->nineteen;
    }

    /**
     * @param mixed $nineteen
     */
    public function setNineteen($nineteen): void
    {
        $this->nineteen = $nineteen;
    }

    /**
     * @return mixed
     */
    public function getSix()
    {
        return $this->six;
    }

    /**
     * @param mixed $six
     */
    public function setSix($six): void
    {
        $this->six = $six;
    }

    /**
     * @return mixed
     */
    public function getSeven()
    {
        return $this->seven;
    }

    /**
     * @param mixed $seven
     */
    public function setSeven($seven): void
    {
        $this->seven = $seven;
    }

    /**
     * @return mixed
     */
    public function getEight()
    {
        return $this->eight;
    }

    /**
     * @param mixed $eight
     */
    public function setEight($eight): void
    {
        $this->eight = $eight;
    }

    /**
     * @return mixed
     */
    public function getTen()
    {
        return $this->ten;
    }

    /**
     * @param mixed $ten
     */
    public function setTen($ten): void
    {
        $this->ten = $ten;
    }

    /**
     * @return mixed
     */
    public function getTwentythree()
    {
        return $this->twentythree;
    }

    /**
     * @param mixed $twentythree
     */
    public function setTwentythree($twentythree): void
    {
        $this->twentythree = $twentythree;
    }

    /**
     * @return mixed
     */
    public function getTwentytwo()
    {
        return $this->twentytwo;
    }

    /**
     * @param mixed $twentytwo
     */
    public function setTwentytwo($twentytwo): void
    {
        $this->twentytwo = $twentytwo;
    }

    /**
     * @return mixed
     */
    public function getEleven()
    {
        return $this->eleven;
    }

    /**
     * @param mixed $eleven
     */
    public function setEleven($eleven): void
    {
        $this->eleven = $eleven;
    }

    /**
     * @return mixed
     */
    public function getSeventeen()
    {
        return $this->seventeen;
    }

    /**
     * @param mixed $seventeen
     */
    public function setSeventeen($seventeen): void
    {
        $this->seventeen = $seventeen;
    }

    /**
     * @return mixed
     */
    public function getThirteen()
    {
        return $this->thirteen;
    }

    /**
     * @param mixed $thirteen
     */
    public function setThirteen($thirteen): void
    {
        $this->thirteen = $thirteen;
    }

    /**
     * @return mixed
     */
    public function getFifteen()
    {
        return $this->fifteen;
    }

    /**
     * @param mixed $fifteen
     */
    public function setFifteen($fifteen): void
    {
        $this->fifteen = $fifteen;
    }

    /**
     * @return mixed
     */
    public function getSixteen()
    {
        return $this->sixteen;
    }

    /**
     * @param mixed $sixteen
     */
    public function setSixteen($sixteen): void
    {
        $this->sixteen = $sixteen;
    }

    /**
     * @return mixed
     */
    public function getTwelve()
    {
        return $this->twelve;
    }

    /**
     * @param mixed $twelve
     */
    public function setTwelve($twelve): void
    {
        $this->twelve = $twelve;
    }


}
