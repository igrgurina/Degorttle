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
        public $_experience;
    
        /**
         *	A public variable
         *
         *	@var float damage done with this soldier's attack to all enemies in one turn
         */
        public $_damage;
    
        /**
         *	A private variable
         *
         *	@var float just for statistics - it's printed when the soldier dies
         */
        private $_totalDamage;
    
        /**
         *	A public variable
         *
         *	@var integer how many enemies are affected with damage by this attack
         */
        public $_affected;
    
        /**
         *	A public variable
         *
         *	@var float decreased by damage, battle engine randomly (but appropriately) afflicts damage to enemy's soldiers
         */
        public $_health;
    
        /**
         *	A public variable
         *
         *	@var string describes the type of the soldier (soldier, tank, ship, ...)
         */
        public $_name;
    
        /**
         *	A public variable
         *
         *	@var _army holds the information where the soldier is positioned (which _army, etc.)
         */
        public $_army;
    
        /**
         *	Sets class variables to default values for basic soldier
         *
         *	@param Army $army a value required for the class Soldier
         *	@return void
         */
        public function __construct($army)
        {
            $this->_experience = 0;
            $this->_affected = 1;
            $this->_damage = 1.5;
            $this->_health = 5;
    
            $this->_name = "Soldier";
            $this->_totalDamage = 0;
            $this->_army = $army;
            //echo "<br /><i>Added new soldier. </i>";        
        }
    
        /**
         *	Makes Soldier class printable
         *
         *	@return string basic info about soldier
         */
        public function __toString()
        {
            return $this->_name . " with " . $this->_experience . " experience points has done total of <b>" . $this->_totalDamage . "</b> damage";
        }
    
        /**
         *	Soldier attacks the enemy
         *
         *	Adds one experience point, stores result from damage calculator
         *	to $_damage and adds it up to the $_totalDamage.
         *
         *	Method doesn't return anything because class $_army takes
         *	care of calculated damage.
         *
         *	@param Battle $battle battle where the soldier fights
         *	@return void
         */
        public function attack($battle)
        {
            ++$this->_experience;
            $this->_damage = $this->calculateDamage($battle);
            $this->_totalDamage = $this->_totalDamage + ($this->_damage * $this->_affected);
        }
    
        /**
         *	Soldier is defending himself
         *
         *	Reduces soldier's $_health by given $dmg, and kills him
         *	if $_health drops to zero.
         *
         *	It also prints appropriate message with soldier's stats.
         *
         *	@param float $dmg amount of damage dealt to soldier
         *	@return void
         */
        public function defend($dmg)
        {
            //echo $this->_health;
            $this->_health = $this->_health - $dmg;
            $this->_experience++;
            if($this->_health <= 0)
            {
                $this->_army->removeSoldier($this);
                echo "<br /> " . $this . " is dead.";
                unset($this);
            }
        }
    
        /**
         *	Basic single man damage calculator
         *
         *	Multiplies $_experience with fixed $_damage, and divides it
         *	with number of soldiers affected by attack.
         *
         *	@param Battle $battle current battle
         *	@return float
         */
        public function calculateDamage($battle)
        {
            return ($this->_experience * $this->_damage) / $this->_affected;
        }
    
        /**
         *	Gets current health of the soldier
         *
         *	@return string string representation of the float $_health
         */
        public function getHealth()
        {
            return strval($this->_health);
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
        public function __construct($_army)
        {
            parent::__construct($_army);
            $this->_affected = 5;
            $this->_damage = 5;
            $this->_health = 12;
            $this->_name = "Tank";
            //echo "<i> You've got tank! OMG </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = 1.0;
            switch($battle->_type)
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
        public function __construct($_army)
        {
            parent::__construct($_army);
            $this->_affected = 10;
            $this->_damage = 6;
            $this->_health = 14;
            $this->_name = "Airplane";
            //echo "<i> You have airforce! OMG </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = 1.0;
            switch($battle->_type)
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
        public function __construct($_army)
        {
            parent::__construct($_army);
            $this->_affected = 10;
            $this->_health = 13;
            $this->_damage = 3;
            $this->_name = "Helicopter";
            //echo "<i> You've got helicopter! Now you can fly and stuff.. </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = 1.0;
            switch($battle->_type)
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
        public function __construct($_army)
        {
            parent::__construct($_army);
            $this->_affected = 7;
            $this->_health = 14;
            $this->_damage = 6;
            $this->_name = "Ship";
            //echo "<i> You now have a ship! WOW.. Such Power! </i>";
        }
    
        public function calculateDamage($battle)
        {
            $bonus = ($battle->_type === 'Water' ? 4 : 0);
            return parent::calculateDamage($battle) * 1.5 * $bonus;
        }
    }
    
    echo "Loading soldiers... <br />"; // just making it fancy
?>
