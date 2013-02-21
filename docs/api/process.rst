.. process.php generated using docpx on 02/21/13 08:52pm


Function
********

process
=======

.. function:: process()


    Creates a new XPSPL Process object.
    
    .. note::
       
       See the ``priority`` and ``exhaust`` functions for setting the priority 
       and exhaust of the created process.

    :param callable: 

    :rtype: void 


Creates a new XPSPL Process object.
RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5

.. code-block::php

   <?php
   
   $process = process(function(){});

   signal(SIG('foo'), $process);



