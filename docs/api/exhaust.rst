.. exhaust.php generated using docpx on 02/21/13 08:52pm


Function
********

exhaust
=======

.. function:: exhaust()


    Registers the given process to have the given exhaust rate.
    
    A rated exhaust allows for you to install processes that exhaust at the set 
    rate rather than 1.
    
    If you require a null exhaust process use the ``null_exhaust`` function.

    :param callable|process: PHP Callable or Process.

    :rtype: object Process


Defining process exhaust.
RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5RST_H5

Defines the given process with an exhaust of 5.

.. code-block:: php

   <?php
   
   signal(SIG('foo'), exhaust(5, function(){
       echo 'foo';
   });

   for($i=0;$i<5;$i++){
       emit('foo');
   }
   
   // results
   // foofoofoofoofoo



