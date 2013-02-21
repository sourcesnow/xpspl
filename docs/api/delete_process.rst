.. delete_process.php generated using docpx on 02/21/13 08:52pm


Function
********

delete_process
==============

.. function:: delete_process()


    Removes an installed signal process.

    :param string|integer|object: Signal process is attached to.
    :param object: Process.

    :rtype: void 


Removing installed processes
RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5

Removes the installed process from the foo signal.

.. code-block::php

   <?php
   $process = signal('foo', function(){});
   
   delete_process('foo', $process);



