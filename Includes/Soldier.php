<?php
    
    /**
     *  Base class for soldiers
     * 
     *  Implements the most basic type of soldier plus methods
     *  for attacking and defending.
     * 
     *  @author Ivan Grgurina <ivan.grgurina@gmail.com>
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
         * 	@param Army $army a value required for the class Soldier
         * 	@return void
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
         * 	Method doesn't return anything because class Army takes
         *	care of calculated damage.
         *
         * 	@param Army $army a value required for the class Soldier
         * 	@return void
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
         * 	It also prints appropriate message with soldier's stats.
         *
         * 	@param float $dmg amount of damage dealt to soldier
         * 	@return void
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
         * 	@param Battle $battle current battle
         * 	@return float
         */
        public function calculateDamage($battle)
        {
            return ($this->experience * $this->damage) / $this->affected;
        }
    
        /**
         *  Gets current health of the soldier
         *
         *  @return string string representation of the float $health
         */
        public function getHealth()
        {
            return strval($this->health);
        }
    }

    
    echo "Loading soldiers... <br />"; // just making it fancy
?>
