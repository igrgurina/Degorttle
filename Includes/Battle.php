<?php
    include("Soldier.php");
    include("Army.php");
    
    echo "Simulator starting... <br />" . PHP_EOL; // just making it fancy
    
    /**
     *  Main class with battle engine
     * 
     *  @author Ivan Grgurina <ivan.grgurina@gmail.com>
     */
    class Battle
    {
        /**
         *	A public variable
         *
         *	@var Army first army fighting this battle
         */
        public $army1;
    
        /**
         *	A public variable
         *
         *	@var Army second army fighting this battle
         */
        public $army2;
    
        /**
         *	A public variable
         *
         *	@var string type of battle
         */
        public $type;
    
        /**
         *	A public variable
         *
         *	@var integer 0: army1, 1: army2
         */
        private $turn;
    
        /**
         *	Sets the background required for starting battle engine
         *
         *  Assigns the type of battle and decides which army starts first attack.
         *
         *  @param Army $one first army
         *  @param Army $two second army
         *  @return void
         */
        public function __construct($one, $two)
        {
            echo "<br />Creating battle simulator.." . PHP_EOL; // just making it fancy
            $this->type = $this->setRandomTypeOfBattle();
            echo "<br />Optimizing terrain..." . PHP_EOL; // just making it fancy
            $this->turn = rand(0, 1);
            $this->army1 = $one;
            $this->army2 = $two;
        }
    
        /**
         *	Sets random type of battle, choosing between predefined options
         *
         *  Chances for the certain type:
         *    Mountain:  10%
         *    Woods:     20%
         *    Water:     30%
         *    Open land: 40%
         *
         *	@return string string representation of battle type
         */
        public function setRandomTypeOfBattle()
        {
            switch(rand(0, 9)) {
                case  0: return 'Mountain';
                case  1: return 'Water';
                case  2: return 'Open land';
                case  3: return 'Water';
                case  4: return 'Open land';
                case  5: return 'Woods';
                case  6: return 'Woods';
                case  7: return 'Water';
                case  8: return 'Open land';
                case  9: return 'Open land';
            }
        }

        /**
         *  Changes turns between armies
         *
         *  This is turn by turn battle.
         *  Directly assigns value to $turn, doesn't return anything.
         *
         *	@return void
         */
        private function changeTurn()
        {
            $this->turn = 1 - $this->turn; // 1-0 = 1, 1-1 = 0
        }
    
        /**
         *	Gets type of battle with a sentence
         *
         *	@return string full sentence with type of battle
         */
        public function getTypeOfBattle()
        {
            return "Type of this battle is: " . $this->type . ".<br />";
        }
    
        /**
         *	Returns current attacker
         *
         *	@return Army the current attacker in this battle
         */
        public function getAttacker()
        {
            return $this->turn === 0 ? $this->army1 : $this->army2;
        }
    
        /**
         *	Returns current defending army
         *
         *	@return Army the current defender in this battle
         */
        public function getDefender()
        {
            return $this->turn === 0 ? $this->army2 : $this->army1;
        }
    
        /**
         *	Starts battle engine
         *
         *  While there is no winner, make attacking army attack defending army
         *  and then change turns.
         *
         *  When there is a winner decided, print it out.
         *
         *	@return void
         */
        public function startBattle()
        {
            echo "Starting battle.. <br />";
            echo "Type of this battle is: <i>" . $this->type . "</i>.<br />";
    
            //while($this->battleFinished())
            for($round = 1; $round < 21; $round++)
            {
                if($this->battleFinished())
                {
                    $this->printStatus();    
                    echo "<br/><br/>The winner is: <b>";
                    echo $this->getWinner() . "</b>!" . PHP_EOL;
                    break;
                }
                
                $this->changeTurn();

                echo "<br /><br />ROUND " . $round . " Attacker: <i>";
                echo $this->getAttacker()->getName();
                echo "</i>\tDefender: <i>";
                echo $this->getDefender()->getName() . "</i>";
                $this->printStatus();

                $this->getAttacker()->fight($this, $this->getDefender());
            }
        }
    
        /**
         *  Prints current status about armies involved in battle
         *
         *  @return void
         */
        private function printStatus()
        {
            echo "<br /><br />Status (number of soldiers alive): <br />";
            echo $this->army1->getName() . ": " . $this->army1->numOfSoldiers . "<br />";
            echo $this->army2->getName() . ": " . $this->army2->numOfSoldiers;
        }
    
        /**
         *	Determines whether one of the armies won
         *
         *  ako su ili jedna ili druga poražene, bitka treba završiti, inače - bitka se nastavlja
         *
         *	@return boolean
         */
        public function battleFinished()
        {
            //return ($this->army1->isDefeated() or $this->army2->isDefeated());
            return $this->getDefender()->isDefeated() or $this->getAttacker()->isDefeated();
        }
    
        /**
         *	Returns winner
         *
         *	@return string name of the winner army
         */
        private function getWinner()
        {
            return $this->army1->isDefeated() ? $this->army2->getName() : $this->army1->getName();
        }
    }
    
    echo 'Battle engine loaded..<br />'; // just making it fancy
    
?>
