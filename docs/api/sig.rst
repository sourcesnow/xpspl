.. sig.php generated using docpx on 02/21/13 08:52pm


Function
********

SIG
===

.. function:: SIG()


    Generates an XPSPL SIG object from the given ``$signal``.
    
    This function is only a shorthand for ``new SIG($signal)``.

    :param string|: Signal process is attached to.

    :rtype: object \XPSPL\SIG


Creating a SIG.
RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5

This will create a SIG idenitified by 'foo'.

.. code-block:: php

   <?php
   signal(SIG('foo'), function(){
       echo "HelloWorld";
   });
   
   emit(SIG('foo'));



