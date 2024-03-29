<?php
namespace app\components;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use app\models\Log;

class Words extends Component
{
    public static $list = [
        'confess',
        'complain',
        'balance',
        'first',
        'support',
        'condition',
        'hydrant',
        'linen',
        'grade',
        'foregoing',
        'tense',
        'plant',
        'whirl',
        'wilderness',
        'office',
        'interrupt',
        'friendly',
        'adhesive',
        'country',
        'excellent',
        'needle',
        'shape',
        'substance',
        'unkempt',
        'spray',
        'escape',
        'exultant',
        'waiting',
        'carve',
        'strengthen',
        'colour',
        'standing',
        'alarm',
        'snake',
        'responsible',
        'marble',
        'observe',
        'nonstop',
        'animated',
        'better',
        'trousers',
        'hapless',
        'damage',
        'chicken',
        'abrupt',
        'strap',
        'axiomatic',
        'stitch',
        'coil',
        'surprise',
        'water',
        'colorful',
        'water',
        'receipt',
        'spring',
        'hideous',
        'flower',
        'overflow',
        'impolite',
        'perfect',
        'behavior',
        'jumbled',
        'incredible',
        'right',
        'callous',
        'aboriginal',
        'trade',
        'guarantee',
        'orange',
        'purring',
        'ludicrous',
        'secretive',
        'invent',
        'signal',
        'mysterious',
        'explain',
        'profit',
        'fuzzy',
        'difficult',
        'frighten',
        'library',
        'waves',
        'badge',
        'obedient',
        'alike',
        'brush',
        'grouchy',
        'orange',
        'bare',
        'wobble',
        'discover',
        'grain',
        'screw',
        'deranged',
        'existence',
        'deadpan',
        'synonymous',
        'likeable',
        'search',
        'ducks',
        'reign',
        'destruction',
        'private',
        'lunch',
        'doctor',
        'aromatic',
        'creepy',
        'obscene',
        'listen',
        'bottle',
        'daffy',
        'flavor',
        'defiant',
        'writing',
        'kittens',
        'decide',
        'birthday',
        'melodic',
        'separate',
        'deeply',
        'hellish',
        'godly',
        'scent',
        'roasted',
        'contain',
        'efficient',
        'fixed',
        'shelf',
        'straw',
        'succeed',
        'daughter',
        'eight',
        'wandering',
        'conscious',
        'successful',
        'puzzled',
        'level',
        'measly',
        'cushion',
        'lavish',
        'hungry',
        'crate',
        'foolish',
        'carry',
        'fumbling',
        'anxious',
        'notice',
        'enjoy',
        'knife',
        'cabbage',
        'dispensable',
        'sticky',
        'spark',
        'teaching',
        'vagabond',
        'plausible',
        'excuse',
        'behave',
        'mammoth',
        'cheer',
        'expansion',
        'detail',
        'witty',
        'milky',
        'playground',
        'flower',
        'space',
        'feeble',
        'cherries',
        'clear',
        'window',
        'burst',
        'unbecoming',
        'science',
        'utopian',
        'refuse',
        'cold',
        'piquant',
        'thank',
        'glorious',
        'airport',
        'amusing',
        'remove',
        'whole',
        'uttermost',
        'sudden',
        'chase',
        'prefer',
        'madly',
        'clean',
        'needless',
        'well-made',
        'control',
        'plane',
        'pedal',
        'boiling',
        'sneeze',
        'certain',
        'tenuous',
        'average',
        'hobbies',
        'half',
        'early',
        'superb',
        'halting',
        'adventurous',
        'furniture',
        'identify',
        'heady',
        'yellow',
        'person',
    ];

    public static function random()
    {
        return array_rand(self::$list);
    }
}