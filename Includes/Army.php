<?php
    
    /**
     *  Army class
     * 
     *  @author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Army
    {
        /**
         *	A public variable
         *
         *	@var integer current number of soldiers
         */
        public $numOfSoldiers;
    
        /**
         *	A public variable
         *
         *	@var array list of all active soldiers in this army
         */
        public $soldiers = array();
    
        /**
         *	A private variable
         *
         *	@var string the official name of the army, in this case - country
         */
        private $name;

        /**
         *	Creates army
         *
         *  Sets name, initializes stats-only variables, creates given number $num of soldiers.
         *
         * 	@param integer $num a number of soldiers to be added into army
         * 	@return void
         */
        public function __construct($num)
        {
            $this->setName();
    
            echo "<br />Creating army with " . $num . " soldiers.. <br />" . PHP_EOL;
            $this->numOfSoldiers = $num;
            for ($i = 0; $i < $num; $i++)
            {
                $this->addSoldier();
            }
        }
    
        /**
         *	Makes Army class printable
         *
         *	@return string basic info about army
         */
        public function __toString()
        {
            return "<b>" . $this->name . "</b> => " . PHP_EOL .
            "<br />Soldiers: " . $this->sol . "<br />" . PHP_EOL;
        }    
    
        /* SOLDIER METHODS */

        /**
         *	Adds one soldier to army
         *
         *	@return void
         */
        private function addSoldier()
        {
            // radim posebnu fju za dodavanje samo 1 vojnika jer planiram imati više tipova vojnika, koje ću na random odabirati
            array_push($this->soldiers, new Soldier($this));
        }
    
        /**
         *	Removes soldier from the army when he dies
         *
         *  Using array_splice reorders the index keys of the $soldiers array nicely, which is required for later features.
         *  The $numOfSoldiers variable is also decreased by one.
         *
         *  @param Soldier $soldier dead soldier that has to be removed from army (and come back to life 3 days later maybe) :P
         *	@return void
         */
        public function removeSoldier($soldier)
        {
            $this->numOfSoldiers--;
            array_splice($this->soldiers, array_search($soldier, $this->soldiers), 1);            
        }
    
        /* BATTLE METHODS */
    
        /**
         *	Function for army that is attacking the $defender army
         *
         *  First, the attack() method is being called upon every soldier.
         *  The damage dealt by that soldier is then inflicted to defending army.
         *
         *  @param Battle $battle current ongoing battle
         *  @param Army $defender defending army
         *	@return void
         */
        public function fight($battle, $defender)
        {
            foreach($this->soldiers as $soldier)
            {
                $soldier->attack($battle);
                $defender->inflictDamage($soldier->damage, $soldier->affected);
            }
        }
    
        /**
         *	Function for army that is defending itself
         *
         *  Deals damage appropriately to members of the defending army.
         *  If the number of affected soldiers $num (by attack) is higher than current number of soldiers in defence,
         *  it's being lowered to that number, thus dealing more damage, but to less targets.
         *
         *  @param float $damage amount of damage dealt by attack
         *  @param int $num number of targets affected by attack
         *	@return void
         */
        public function inflictDamage($damage, $num)
        {
            $count = count($this->soldiers);
            if($count < $num)
            {
                $num = $count;
            }
            $single = $damage / $num; // damage to a single target
            //echo "<i>Total damage to " . $num . " targets will be </i>" . $damage . " .<br />";
    
            for($i = 0; $i < $num; $i++)
            {
                $this->soldiers[$i]->defend($single); // this is why it's important ;)
            }
        }
    
        /**
         *	Checks whether army is defeated
         *
         *  Which actually means checking whether the number of soldiers reached zero.
         *
         *	@return boolean has this army lost the battle?
         */
        public function isDefeated()
        {            
            return $this->numOfSoldiers > 0 ? FALSE : TRUE;
        }
    
        /* NAME METHODS */

        /**
         *	Sets official name for the army
         *
         *	@return void
         */
        private function setName()
        {
            $countries = array('Croatia', 'Serbia', 'Slovenia', 'Italia', 'England', 'Scotland', 'Spain', 'Portugal', 'Mexico', 'Brazil', 'Chile', 'Argentina', 'China');
            $this->name = $countries[rand(0, count($countries) - 1)];
        }

        /**
         *	Gets official name of the army
         *
         *	@return string name of the army
         */
        public function getName()
        {
            return $this->name;
        }
    
        /* STATISTICS METHODS */
        /* NOT USED ANYMORE, but still nice if you want to see what's happening */
        public function printStats()
        {
            $this->printHealth();
            echo "<br/> " . $this->numOfSoldiers . " soldiers are still alive.";
        }    
        public function printHealth()
        {
            $arr = array();
            foreach($this->soldiers as $soldier)
            {
                array_push($arr, $soldier->getHealth());
            }
            echo implode(" : ", $arr);
        }
    }
    
    echo "Loading armies... <br />" . PHP_EOL; // just making it fancy
?>
