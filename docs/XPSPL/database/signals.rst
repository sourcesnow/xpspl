.. /database/signals.php generated using docpx v1.0.0 on 01/13/14 04:53pm


Class - XPSPL\\database\\Signals
********************************

Signal Database

A database of signals.

All signals are stored in a database by their index.

Each signal stored has a copy of the signal and it's process database.

Methods
-------

find_signal
+++++++++++

.. function:: find_signal($signal)


    Finds the signal in the database.
    
    Returns null if the signal does not exit.

    :param object: 

    :rtype: object 



register_signal
+++++++++++++++

.. function:: register_signal($signal, $database)


    Registers a signal in the database with the given processes database.

    :param object: \XPSPL\SIG
    :param object: \XPSPL\database\Processes

    :rtype: void 



delete_signal
+++++++++++++

.. function:: delete_signal($signal)


    Deletes a signal from the database.

    :param object: \XPSPL\SIG

    :rtype: void 



find_processes_database
+++++++++++++++++++++++

.. function:: find_processes_database($signal)


    Finds and returns the given signals processes database.

    :param object: \XPSPL\Sig

    :rtype: null|object Processes



signals
=======
PHP File @ /database/signals.php

.. code-block:: php

	<?php
	namespace XPSPL\database;
	/**
	 * Copyright 2010-12 Nickolas Whiting. All rights reserved.
	 * Use of this source code is governed by the Apache 2 license
	 * that can be found in the LICENSE file.
	 */
	
	/**
	 * Signal Database
	 * 
	 * A database of signals.
	 *
	 * All signals are stored in a database by their index.
	 *
	 * Each signal stored has a copy of the signal and it's process database.
	 */
	class Signals extends \XPSPL\Database {
	
	    /**
	     * Finds the signal in the database.
	     *
	     * Returns null if the signal does not exit.
	     *
	     * @param  object  $signal  
	     *
	     * @return  object
	     */
	    public function find_signal(\XPSPL\SIG $signal)
	    {
	        if ($this->offsetExists($signal->get_index())) {
	            return $this->offsetGet($signal->get_index());
	        }
	        return null;
	    }
	
	    /**
	     * Registers a signal in the database with the given processes database.
	     *
	     * @param  object  $signal \XPSPL\SIG
	     * @param  object  $database  \XPSPL\database\Processes
	     *
	     * @return  void
	     */
	    public function register_signal(\XPSPL\SIG $signal, Processes $database)
	    {
	        $index = $signal->get_index();
	        $this->_storage[$index] = [$signal, $database];
	    }
	
	    /**
	     * Deletes a signal from the database.
	     *
	     * @param  object  $signal  \XPSPL\SIG
	     *
	     * @return  void
	     */
	    public function delete_signal(\XPSPL\SIG $signal)
	    {
	        if ($this->offsetExists($signal->get_index())) {
	            $this->offsetUnset($signal->get_index());
	            return;
	        }
	        return;
	    }
	
	    /**
	     * Finds and returns the given signals processes database.
	     *
	     * @param  object  $signal  \XPSPL\Sig
	     *
	     * @return  null|object  Processes
	     */
	    public function find_processes_database(\XPSPL\SIG $signal)
	    {
	        $find = $this->find_signal($signal);
	        if (null === $find) {
	            return null;
	        }
	        return $find[1];
	    }
	}

Created on 01/13/14 04:53pm using `Docpx <http://github.com/prggmr/docpx>`_