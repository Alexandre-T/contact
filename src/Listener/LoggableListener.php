<?php
/**
 * This file is part of the Contact Application.
 *
 * PHP version 7.2
 *
 * (c) Alexandre Tranchant <alexandre.tranchant@gmail.com>
 *
 * @category Listener
 *
 * @author    Alexandre Tranchant <alexandre.tranchant@gmail.com>
 * @copyright 2019 Cerema
 * @license   CeCILL-B V1
 *
 * @see       http://www.cecill.info/licences/Licence_CeCILL-B_V1-en.txt
 */

namespace App\Listener;

use Gedmo\Loggable\LoggableListener as GedmoLoggableListener;

/**
 * LoggableListener.
 *
 * @author Alexandre Tranchant <alexandre.tranchant@gmail.com>
 */
class LoggableListener extends GedmoLoggableListener implements LoggableListenerInterface
{
}
