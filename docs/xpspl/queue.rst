.. queue.php generated using docpx on 01/31/13 10:43pm


Class - XPSPL\\Queue
********************

Queue

A database of signal processes.

As of v0.3.0 Queues no longer maintain a reference to a signal.

The Queue is still a representation of a PriorityQueue and will remain so 
until the issues with PHP's current implementation are addressed.

Methods
-------

enqueue
+++++++

.. function:: enqueue($node, [$priority = false])


    Pushes a new process into the queue.

    :param mixed: Variable to store
    :param integer: Priority of the callable

    :rtype: void 



dequeue
+++++++

.. function:: dequeue($node)


    Removes a process from the queue.

    :param mixed: Reference to the node.

    :throws InvalidArgumentException: 

    :rtype: boolean 



sort
++++

.. function:: sort()


    Sorts the queue.

    :rtype: void 




Last updated on 01/31/13 10:43pm