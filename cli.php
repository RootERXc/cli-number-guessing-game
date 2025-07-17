<?
trait Close 
{
    private function __construct ()
    {
    }

    private function __clone ()
    {
    }

    private function __wakeup ()
    {
    }

    private function __sleep ()
    {
    }
}

final class Rounds 
{
    const WELCOME_MESSAGE = 'Добро пожаловать в игру Угадай Число!';
    
    private static $rounds = array ();

    public static function prepare () {
        echo self::WELCOME_MESSAGE, PHP_EOL, PHP_EOL;

        $round = array ();

        $mode = Mode::selectMode();

        if (!($mode instanceof Mode)):
            echo 'Выбор режима игры недоступен.', PHP_EOL;

            return;
        endif;

        $round['mode'] = $mode;

        $difficulty = Difficulty::selectDifficulty();

        if (!($difficulty instanceof Difficulty)):
            echo 'Выбор сложности игры недоступен.', PHP_EOL;

            return;
        endif;

        $round['difficulty'] = $difficulty;

        var_dump($round);
    }

    use Close;
}

abstract class Mode
{
    abstract protected function start ();

    final public static function selectMode (): ?Mode
    {
        $modes = getSubclasses ('Mode');

        $select_mode = NULL;

        if (count($modes) < 2)
            if (count($modes) == 1):
                $select_mode = $modes[0];

                goto skip_select_mode;
            else:
                return null;
            endif;

        do 
        {
            echo 'Выберите режим игры:', PHP_EOL;

            self::displayModes($modes);

            $index = (int) trim(fgets(STDIN)) - 1;

            if (!empty (array_key_exists ($index, $modes))):
                $select_mode = $modes[$index];

                echo PHP_EOL, "Выбран режим $modes[$index]", PHP_EOL, PHP_EOL;

                break;
            endif;
        } 
        while (true);

        skip_select_mode:

        $mode = new $select_mode;

        return $mode;
    }

    public static function displayModes (array $modes)
    {
        for ($i = 0; $i < count ($modes); $i ++)
        {
            $mode = $modes[$i];

            echo $i + 1, '. ', $mode, PHP_EOL;
        }
    }
}

class Standart extends Mode
{
    private int $random_number;

    public function __construct ()
    {
        $this->random_number = rand (1, 100);
    }

    protected function start ()
    {
    }
}

class Standart2 extends Mode
{
    protected function start ()
    {
    }
}

abstract class Difficulty
{
    protected int $chances = 1;

    final public static function selectDifficulty (): ?Difficulty
    {
        $difficulties = getSubclasses ('Difficulty');

        $select_difficulty = NULL;

        if (count($difficulties) < 2)
            if (count($difficulties) == 1):
                $select_difficulty = $difficulties[0];

                goto skip_select_mode;
            else:
                return null;
            endif;

        do 
        {
            echo 'Выберите сложность игры:', PHP_EOL;

            self::displayDifficulties($difficulties);

            $index = (int) trim(fgets(STDIN)) - 1;

            if (!empty (array_key_exists ($index, $difficulties))):
                $select_difficulty = $difficulties[$index];

                echo PHP_EOL, "Выбрана сложность $difficulties[$index]", PHP_EOL, PHP_EOL;

                break;
            endif;
        } 
        while (true);

        skip_select_mode:

        $difficulty = new $select_difficulty;

        return $difficulty;
    }

    public static function displayDifficulties (array $difficulties)
    {
        for ($i = 0; $i < count ($difficulties); $i ++)
        {
            $difficulty = $difficulties[$i];

            echo $i + 1, '. ', $difficulty, PHP_EOL;
        }
    }
}

class Easy extends Difficulty
{
    protected int $chances = 10;
}

class Medium extends Difficulty 
{
    protected int $chances = 5;
}

class Hard extends Difficulty 
{
    protected int $chances = 3;
}

function getSubclasses ($class) 
{
    $array = array ();

    foreach (get_declared_classes () as $subclass) 
    {
        if (is_subclass_of ($subclass, $class))
            $array[] = $subclass;
    }

    return $array;
}

Rounds::prepare ();