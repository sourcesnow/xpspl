.. /erase_signal_history.php generated using docpx v1.0.0 on 03/02/14 12:15pm


xp_erase_signal_history
***********************


.. function:: xp_erase_signal_history($signal)


    Erases the history of only the given signal.
    
    .. warning::
    
        This will delete the history for *ANY* signals that are a direct child of
        the to be deleted signal.
    
        As an example,
    
        When ``sig_foo`` emits it is proceeded directly by ``sig_foo2`` emitting
        within the ``sig_foo`` execution.
    
        When sig_foo is deleted the history of sig_foo_child will also be removed.

    :param string|object: Signal to be erased from history.

    :rtype: void 





