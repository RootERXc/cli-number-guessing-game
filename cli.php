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

    public static function start () {
        echo self::WELCOME_MESSAGE, PHP_EOL;

        $select_mode = Mode::selectMode();

        if ($select_mode == false):
            echo 'Нету доступных режимов игры.';

            return;
        endif;


        // $difficulties = getSubclasses ('Difficulty');
    }

    use Close;
}

abstract class Mode
{

    public static function selectMode () 
    {
        $modes = getSubclasses ('Mode');

        $select_mode = NULL;

        if (count($modes) < 2)
            if (count($modes) == 1):
                $select_mode = $modes[0];

                goto skip_select_mode;
            else:
                return false;
            endif;

        do {
            echo 'Выберите режим игры:', PHP_EOL;

            self::displayModes($modes);

            fscanf(STDIN, "%d\n", $index);

            $index--;

            if (!empty (array_key_exists ($index, $modes))):
                $select_mode = $modes[$index];

                echo "Выбран режим $modes[$index]", PHP_EOL;

                break;
            endif;
        } while (true);

        skip_select_mode:

        $mode = new $select_mode;

        return $mode;
    }

    public static function displayModes (array $modes)
    {
        for ($i = 0; $i < count ($modes); $i ++)
        {
            $mode = $modes [$i];

            echo $i + 1, '. ', $mode, PHP_EOL;
        }
    }
}

class Standart extends Mode
{
}

class Standart2 extends Mode
{
}

abstract class Difficulty
{
    protected int $chances = 1;

    public function selectDifficulty () 
    {

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

Rounds::start();