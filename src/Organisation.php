<?php

namespace Scouterna\Mocknet;

class Organisation extends \Faker\Provider\Base
{
    protected static $animals = [
        "Aardvark", "Albatross", "Alligator", "Alpaca", "Ant", "Anteater",
        "Antelope", "Ape", "Armadillo", "Donkey", "Baboon", "Badger",
        "Barracuda", "Bat", "Bear", "Beaver", "Bee", "Bison", "Boar",
        "Buffalo", "Butterfly", "Camel", "Capybara", "Caribou", "Cassowary",
        "Cat", "Caterpillar", "Cattle", "Chamois", "Cheetah", "Chicken",
        "Chimpanzee", "Chinchilla", "Chough", "Clam", "Cobra", "Cockroach",
        "Cod", "Cormorant", "Coyote", "Crab", "Crane", "Crocodile", "Crow",
        "Curlew", "Deer", "Dinosaur", "Dog", "Dogfish", "Dolphin", "Donkey",
        "Dotterel", "Dove", "Dragonfly", "Duck", "Dugong", "Dunlin", "Eagle",
        "Echidna", "Eel", "Eland", "Elephant", "Elephant-seal", "Elk", "Emu",
        "Falcon", "Ferret", "Finch", "Fish", "Flamingo", "Fly", "Fox", "Frog",
        "Gaur", "Gazelle", "Gerbil", "Giant-panda", "Giraffe", "Gnat", "Gnu",
        "Goat", "Goose", "Goldfinch", "Goldfish", "Gorilla", "Goshawk",
        "Grasshopper", "Grouse", "Guanaco", "Guinea-fowl", "Guinea-pig",
        "Gull", "Hamster", "Hare", "Hawk", "Hedgehog", "Heron", "Herring",
        "Hippopotamus", "Hornet", "Horse", "Human", "Hummingbird", "Hyena",
        "Ibex", "Ibis", "Jackal", "Jaguar", "Jay", "Jellyfish", "Kangaroo",
        "Kingfisher", "Koala", "Komodo-dragon", "Kookabura", "Kouprey", "Kudu",
        "Lapwing", "Lark", "Lemur", "Leopard", "Lion", "Llama", "Lobster",
        "Locust", "Loris", "Louse", "Lyrebird", "Magpie", "Mallard", "Manatee",
        "Mandrill", "Mantis", "Marten", "Meerkat", "Mink", "Mole", "Mongoose",
        "Monkey", "Moose", "Mouse", "Mosquito", "Mule", "Narwhal", "Newt",
        "Nightingale", "Octopus", "Okapi", "Opossum", "Oryx", "Ostrich",
        "Otter", "Owl", "Ox", "Oyster", "Panther", "Parrot", "Partridge",
        "Peafowl", "Pelican", "Penguin", "Pheasant", "Pig", "Pigeon",
        "Polar-bear", "Pony", "Porcupine", "Porpoise", "Prairie-dog", "Quail",
        "Quelea", "Quetzal", "Rabbit", "Raccoon", "Rail", "Ram", "Rat",
        "Raven", "Red-deer", "Red-panda", "Reindeer", "Rhinoceros", "Rook",
        "Salamander", "Salmon", "Sand-dollar", "Sandpiper", "Sardine",
        "Scorpion", "Sea-lion", "Sea-urchin", "Seahorse", "Seal", "Shark",
        "Sheep", "Shrew", "Skunk", "Snail", "Snake", "Sparrow", "Spider",
        "Spoonbill", "Squid", "Squirrel", "Starling", "Stingray", "Stinkbug",
        "Stork", "Swallow", "Swan", "Tapir", "Tarsier", "Termite", "Tiger",
        "Toad", "Trout", "Turkey", "Turtle", "Vicuña", "Viper", "Vulture",
        "Wallaby", "Walrus", "Wasp", "Water-buffalo", "Weasel", "Whale",
        "Wolf", "Wolverine", "Wombat", "Woodcock", "Woodpecker", "Worm",
        "Wren", "Yak", "Zebra"
    ];

    protected static $groupRole = [
        'Accountant', 'Archive Manager', 'Branch Manager Beaver Scout',
        'Branch Manager Challenge Scout', 'Branch Manager Discover Scout',
        'Branch Manager Family Scout', 'Branch Manager Jeopardize Scout',
        'Branch Manager Tracing Scout', 'Director', 'Boat Committee',
        'Boat controller', 'Challenge Scout mail Recipient',
        'Christmas Market Committee', 'Company thanks', 'Competition Manager',
        'Cottage Committee', 'Cottage rental', 'Deputy Auditor',
        'Deputy Director', 'Attorney Disabled', 'Editor',
        'employeegroup office', 'Equipment Committee', 'Grant agent',
        'Group Camp Committee', 'Group Camp Leader', 'Group_Committee_1',
        'Group Committee 2', 'Group Committee 3', 'Group Committee 4',
        'Group Committee 5', 'Honorary Member', 'Holiday Editor', 'Information',
        'International Agent', 'IT manager', 'JOTA/JOTI leader', 'Group Chair',
        'Local Manager', 'Mail recipient', 'Material Editor',
        'Member registrant', 'New notifications', 'Election committee',
        'Other leader', 'Parents', 'Planning manager', 'Project admin',
        'Inspection head', 'Quartermaster', 'Queue Manager',
        'Rekryteringsansvarig', 'Rover Scout Leader', 'Rover scout',
        'Safety manager', 'Scout Challenge Representative',
        'Scout Hall Committee', 'Scout goods Agent', 'Secretary',
        'Sports leader', 'Trainer', 'Treasurer', 'Av DS Designated Manager',
        'Walpurgis Committee', 'Webmaster', 'Deputy Group Chair',
        '2nd Deputy Group Chair', 'Vice Treasurer',
    ];

    protected static $troopRole = [
        'Scout Leader',
        'Member Registrar',
        'Leader',
        'Assistant Scout Leader',
    ];

    protected static $patrolRole = [
        'Leader',
        'Vice Leader'
    ];

    public static function troopName()
    {
        return static::randomElement(static::$animals) . ' Troop';
    }

    public static function patrolName()
    {
        return static::randomElement(static::$animals) . ' Patrol';
    }

    public static function scoutGroupName()
    {
        return static::randomElement(static::$animals) . ' Group';
    }

    public static function scoutGroupRole()
    {
        return static::randomElement(static::$groupRole);
    }

    public static function troopRole()
    {
        return static::randomElement(static::$troopRole);
    }

    public static function patrolRole()
    {
        return static::randomElement(static::$patrolRole);
    }
}
