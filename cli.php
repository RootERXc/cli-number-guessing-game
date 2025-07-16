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

        $types = getSubclasses ('Mode');

        $select_type = NULL;

        if (count($types) < 2)
            if (count($types) == 1):
                $select_type = $types[0];

                goto skip_select_mode;
            else:
                echo 'Нету доступных режимов игры.';

                return;
            endif;

        echo 'Выберите режим:', PHP_EOL;

        for ($i = 0; $i < count ($types); $i ++)
        {
            $type = $types [$i];

            echo $i + 1, '. ', $type, PHP_EOL;
        }

        do {
            fscanf(STDIN, "%d\n", $index);

            $index--;

            if (!empty (array_key_exists ($index, $types))):
                $select_type = $types[$index];

                echo "Выбран режим $types[$index]", PHP_EOL;

                break;
            else:
                echo 'Режима с таким номером не существует.', PHP_EOL;
            endif;
        } while (true);

        skip_select_mode:

        // $difficulties = getSubclasses ('Difficulty');
    }

    use Close;
}

abstract class Mode
{

    public function selectType () 
    {

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