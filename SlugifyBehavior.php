<?php
/**
 * @author Michał Skrzypek <mcskrzypek@gmail.com>
 * @date date(2019-04-10)
 * @version 1.0
 */
namespace App\Model\Behavior;

use ArrayObject;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\Utility\Text;

/**
 * SlugifyBehavior
 */
class SlugifyBehavior extends Behavior
{

    /**
     * Default Configuration
     * 'field' is the field SlugifyBehavior should be applied to
     * 'parentField' is what would be used to create a slug from if
     * 'field' value is empty
     * @var array
     */
    protected $_defaultConfig = [
        'field'       => 'slug',
        'parentField' => 'name',
    ];

    /**
     * Before Marshal event
     *
     * @param Event        $event   The Event.
     * @param \ArrayObject $data    Array of data to modify.
     * @param \ArrayObject $options Array of additional options.
     *
     * @return void
     */
    public function beforeMarshal(Event $event, ArrayObject $data, ArrayObject $options): void
    {
        if (!empty($data[$this->getConfig('field')])) {
            $data[$this->getConfig('field')] = Text::slug(strtolower(Text::transliterate($data[$this->getConfig('field')])));
        } elseif (!empty($data[$this->getConfig('parentField')])) {
            $data[$this->getConfig('field')] = Text::slug(strtolower(Text::transliterate($data[$this->getConfig('parentField')])));
        } else {
            $event->stopPropagation();
        }
    }
}
