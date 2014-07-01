<?php
    
    /**
     *	Base class for soldiers
     * 
     *	Implements the most basic type of soldier plus methods
     *	for attacking and defending.
     * 
     *	@author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Soldier
    {
        /**
         *	A public variable
         *
         *	@var integer number of experience points, which is equal to number of hits
         */
        public $experience;
    
        /**
         *	A public variable
         *
         *	@var float damage done with this soldier's attack to all enemies in one turn
         */
        public $damage;
    
        /**
         *	A private variable
         *
         *	@var float just for statistics - it's printed when the soldier dies
         */
        private $totalDamage;
    
        /**
         *	A public variable
         *
         *	@var integer how many enemies are affected with damage by this attack
         */
        public $affected;
    
        /**
         *	A public variable
         *
         *	@var float decreased by damage, battle engine randomly (but appropriately) afflicts damage to enemy's soldiers
         */
        public $health;
    
        /**
         *	A public variable
         *
         *	@var string describes the type of the soldier (soldier, tank, ship, ...)
         */
        public $name;
    
        /**
         *	A public variable
         *
         *	@var Army holds the information where the soldier is positioned (which army, etc.)
         */
        public $ARMY;
    
        /**
         *	Sets class variables to default values for basic soldier
         *
         *	@param Army $army a value required for the class Soldier
         *	@return void
         */
        public function __construct($army)
        {
            $this->experience = 0;
            $this->affected = 1;
            $this->damage = 1.5;
            $this->health = 5;
    
            $this->name = "Soldier";
            $this->totalDamage = 0;
            $this->ARMY = $army;
            //echo "<br /><i>Added new soldier. </i>";        
        }
    
        /**
         *	Makes Soldier class printable
         *
         *	@return string basic info about soldier
         */
        public function __toString()
        {
            return $this->name . " with " . $this->experience . " experience points has done total of <b>" . $this->totalDamage . "</b> damage";
        }
    
        /**
         *	Soldier attacks the enemy
         *
         *	Adds one experience point, stores result from damage calculator
         *	to $damage and adds it up to the $totalDamage.
         *
         *	Method doesn't return anything because class Army takes
         *	care of calculated damage.
         *
         *	@param Army $army a value required for the class Soldier
         *	@return void
         */
        public function attack($battle)
        {
            ++$this->experience;
            $this->damage = $this->calculateDamage($battle);
            $this->totalDamage = $this->totalDamage + ($this->damage * $this->affected);
        }
    
        /**
         *	Soldier is defending himself
         *
         *	Reduces soldier's $health by given $dmg, and kills him
         *	if $health drops to zero.
         *
         *	It also prints appropriate message with soldier's stats.
         *
         *	@param float $dmg amount of damage dealt to soldier
         *	@return void
         */
        public function defend($dmg)
        {
            //echo $this->health;
            $this->health = $this->health - $dmg;
            $this->experience++;
            if($this->health <= 0)
            {
                $this->ARMY->removeSoldier($this);
                echo "<br /> " . $this . " is dead.";
                unset($this);
            }
        }
    
        /**
         *	Basic single man damage calculator
         *
         *	Multiplies $experience with fixed $damage, and divides it
         *	with number of soldiers affected by attack.
         *
         *	@param Battle $battle current battle
         *	@return float
         */
        public function calculateDamage($battle)
        {
            return ($this->experience * $this->damage) / $this->affected;
        }
    
        /**
         *	Gets current health of the soldier
         *
         *	@return string string representation of the float $health
         */
        public function getHealth()
        {
            return strval($this->health);
        }
    }
    
    /**
     *	Extends Soldier class with specific options for tanks
     * 
     *	Tanks do 100x more damage in open land, none in the water, ...
     *	Bla bla lot of numbers that can (should) change in the future.
     * 
     *	@author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Tank extends Soldier
    {
        public function __construct($army)
        {
            parent::__construct($army);
            $this->affected = 5;
            $this->damage = 5;
            $this->health = 12;
            $this->name = "Tank";
            //echo "<i> You've got tank! OMG </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = 1.0;
            switch($battle->type)
            {
                case 'Water': { $bonus = 0; break; }
                case 'Open land': { $bonus = 3; break; }
                case 'Mountain': { $bonus = 0.9; break; }
                case 'Woods': { $bonus = 0.7; break; }
                default: { $bonus = 1.0; break; }
            }
            return parent::calculateDamage($battle) * 1.5 * $bonus;
        }
    }
    
    /**
     *	Extends Soldier class with specific options for airforce airplanes
     * 
     *	Airforce is a that game changer you just have to have.
     *	Bla bla lot of numbers that can (should) change in the future.
     * 
     *	@author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Airforce extends Soldier
    {
        public function __construct($army)
        {
            parent::__construct($army);
            $this->affected = 10;
            $this->damage = 6;
            $this->health = 14;
            $this->name = "Airplane";
            //echo "<i> You have airforce! OMG </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = 1.0;
            switch($battle->type)
            {
                case 'Water':
                case 'Open land': { $bonus = 1.5; break; }
                case 'Mountain':
                case 'Woods': { $bonus = 2.5; break; }
                default: { $bonus = 1.0; break; }
            }
            return parent::calculateDamage($battle) * 1.5 * $bonus;
        }
    }
    
    /**
     *	Extends Soldier class with specific options for helicopters
     *
     *	Bla bla lot of numbers that can (should) change in the future.
     *
     *	@author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Helicopter extends Soldier
    {
        public function __construct($army)
        {
            parent::__construct($army);
            $this->affected = 10;
            $this->health = 13;
            $this->damage = 3;
            $this->name = "Helicopter";
            //echo "<i> You've got helicopter! Now you can fly and stuff.. </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = 1.0;
            switch($battle->type)
            {
                case 'Water':
                case 'Open land': { $bonus = 1.5; break; }
                case 'Mountain':
                case 'Woods': { $bonus = 1.25; break; }
                default: { $bonus = 1.0; break; }
            }
            return parent::calculateDamage($battle) * 1.25 * $bonus;
        }
    }
    
    /**
     *	Extends Soldier class with specific options for navy ships
     *
     *	Bla bla lot of numbers that can (should) change in the future.
     * 
     *	@author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Navy extends Soldier
    {
        public function __construct($army)
        {
            parent::__construct($army);
            $this->affected = 7;
            $this->health = 14;
            $this->damage = 6;
            $this->name = "Ship";
            //echo "<i> You now have a ship! WOW.. Such Power! </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = ($battle->type === 'Water' ? 4 : 0);
            return parent::calculateDamage($battle) * 1.5 * $bonus;
        }
    }
    
    echo "Loading soldiers... <br />"; // just making it fancy
?>
