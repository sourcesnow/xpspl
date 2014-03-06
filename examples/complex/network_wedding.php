<?php

xp_import('network');

$server = network\connect('0.0.0.0', ['port' => 8000]);

$server->on_read(function($signal){
  $read = trim($signal->socket->read());
  if ($read == null) {
      return false;
  }
  xp_emit(XP_SIG($read));
});

// Once a bride, groom and bell signals are emitted we emit the wedding.
$wedding = xp_complex_sig(function($signal){
  if (!isset($this->reset) || $this->reset) {
      $this->reset = false;
      $this->bride = false;
      $this->groom = false;
      $this->bells = false;
  }
  switch (true) {
      case $signal->compare(XP_SIG('groom')):
          $this->groom = true;
          break;
      case $signal->compare(XP_SIG('bride')):
          $this->bride = true;
          break;
      case $signal->compare(XP_SIG('bells')):
          $this->bells = true;
          break;
  }
  if ($this->groom && $this->bride && $this->bells) {
      $this->reset = true;
      return true;
  }
  return false;
});

xp_signal($wedding, function(){
  echo 'A wedding just happened.';
});