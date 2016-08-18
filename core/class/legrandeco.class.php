<?php

/* This file is part of Jeedom.
*
* Jeedom is free software: you can redistribute it and/or modify
* it under the terms of the GNU General Public License as published by
* the Free Software Foundation, either version 3 of the License, or
* (at your option) any later version.
*
* Jeedom is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
* GNU General Public License for more details.
*
* You should have received a copy of the GNU General Public License
* along with Jeedom. If not, see <http://www.gnu.org/licenses/>.
*/

require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class legrandeco extends eqLogic {

  public static $_widgetPossibility = array('custom' => true);

  public static function cron() {
    foreach (eqLogic::byType('legrandeco',true) as $legrandeco) {
        $legrandeco->getInformations();
        $legrandeco->getTeleinfo();
        $legrandeco->getData();
    }

  }

  public static function cronHourly() {
    foreach (eqLogic::byType('legrandeco',true) as $legrandeco) {
      $legrandeco->getConso($legrandeco->getId());
    }

  }


  public function preUpdate() {
    if ($this->getConfiguration('addr') == '') {
      throw new Exception(__('L\'adresse ne peut être vide',__FILE__));
    }
  }

  public function postUpdate() {
    $this->getInformations();
    $this->getData();
    $this->getConso($this->getId());
    $this->getTeleinfo();
  }

  public function toHtml($_version = 'dashboard') {
    $replace = $this->preToHtml($_version);
    if (!is_array($replace)) {
      return $replace;
    }
    $version = jeedom::versionAlias($_version);
    if ($this->getDisplay('hideOn' . $version) == 1) {
      return '';
    }

    foreach ($this->getCmd('info') as $cmd) {
      $replace['#' . $cmd->getLogicalId() . '_history#'] = '';
      $replace['#' . $cmd->getLogicalId() . '_id#'] = $cmd->getId();
      $replace['#' . $cmd->getLogicalId() . '#'] = $cmd->execCmd();
      $replace['#' . $cmd->getLogicalId() . '_collect#'] = $cmd->getCollectDate();
      if ($cmd->getIsHistorized() == 1) {
        $replace['#' . $cmd->getLogicalId() . '_history#'] = 'history cursor';
      }
    }

    $data = $this->getCmd(null, 'data1');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data1#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-bolt"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>1 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data1#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $data = $this->getCmd(null, 'data2');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data2#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-bolt"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>2 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data2#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $data = $this->getCmd(null, 'data3');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data3#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-bolt"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>3 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data3#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $data = $this->getCmd(null, 'data4');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data4#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-bolt"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>4 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data4#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $data = $this->getCmd(null, 'data5');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data5#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-bolt"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>5 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data5#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $data = $this->getCmd(null, 'data6m3');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data6#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-cloud"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>1 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data6#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $data = $this->getCmd(null, 'data7m3');
    if (is_object($data) && $data->getIsVisible()) {
      $replace['#data7#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center><i class="fa fa-cloud"></i></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="' . $data->getId() . '"><b>2 : ' . $data->getConfiguration('value') . ' W</b></span></div>';
    } else {
      $replace['#data7#'] = '<div class="col-md-4 data1' . $this->getId() . '"><center></center></div><div class="col-md-8 data1' . $this->getId() . '"><span class="cmd tooltips cmd cmd-widget" data-type="info" data-subtype="numeric" data-cmd_id="data"></span></div>';
    }

    $html = template_replace($replace, getTemplate('core', $version, 'legrandeco', 'legrandeco'));
    cache::set('legrandecoWidget' . $_version . $this->getId(), $html, 0);
    return $html;
  }

  public function getInformations() {
    $addr = $this->getConfiguration('addr', '');
    $devAddr = 'http://' . $addr . '/inst.json';
    $devResult = legrandeco::curl_get_file_contents($devAddr);
    log::add('legrandeco', 'debug', 'getInformations ' . $devAddr);
    if ($devResult === false) {
      log::add('legrandeco', 'info', 'problème de connexion ' . $devAddr);
    } else {
      $devResbis = utf8_encode($devResult);
      $devList = json_decode($devResbis, true);
      log::add('legrandeco', 'debug', print_r($devList, true));
      foreach($devList as $name => $value) {
        if ($name === 'heure' || $name === 'minute') {
          // pas de traitement sur l'heure
        } else {
          log::add('legrandeco', 'debug', 'Sonde trouvée : ' . $name . ', valeur ' . $value);
          $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($this->getId(),$name);
          if (!is_object($cmdlogic)) {
            log::add('legrandeco', 'debug', 'Information non existante, création');
            $newLegrand = new legrandecoCmd();
            $newLegrand->setEqLogic_id($this->getId());
            $newLegrand->setEqType('legrandeco');
            $newLegrand->setIsVisible(1);
            $newLegrand->setIsHistorized(0);
            $newLegrand->setSubType('numeric');
            $newLegrand->setLogicalId($name);
            $newLegrand->setType('info');
            $newLegrand->setName( 'Information - ' . $name );
            $newLegrand->setConfiguration('name', $name);
            $newLegrand->setConfiguration('value', $value);
            $newLegrand->setConfiguration('type', 'inst');
            $newLegrand->save();
            $newLegrand->event($value);
          } else {
            $cmdlogic->setConfiguration('value', $value);
            $cmdlogic->setConfiguration('type', 'inst');
            $cmdlogic->save();
            $cmdlogic->event($value);
          }
        }
      }
    }
    $this->refreshWidget();
  }

  public function getTeleinfo() {
    $addr = $this->getConfiguration('addr', '');
    $devAddr = 'http://' . $addr . '/1.html';
    $devResult = legrandeco::curl_get_file_contents($devAddr);
    log::add('legrandeco', 'debug', 'getInformations ' . $devAddr);
    if ($devResult === false) {
      log::add('legrandeco', 'info', 'problème de connexion ' . $devAddr);
    } else {
      $values = array('tarif' => 'Tarif en Cours',
      'isousc' => 'Intensité Souscrite',
      'conso_base' => 'Index Base',
      'conso_hc' => 'Index HC',
      'conso_hp' => 'Index HP',
      'conso_hc_b' => 'Index HC Bleu',
      'conso_hp_b' => 'Index HP Bleu',
      'conso_hc_w' => 'Index HC Blanc',
      'conso_hp_w' => 'Index HP Blanc',
      'conso_hc_r' => 'Index HC Rouge',
      'conso_hp_r' => 'Index HP Rouge'
    );
    foreach($values as $name => $text) {
      $value = legrandeco::searchValue($devResult, $name);
        log::add('legrandeco', 'debug', 'Sonde trouvée : ' . $name . ', valeur ' . $value);
        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($this->getId(),$name);
        if (!is_object($cmdlogic)) {
          log::add('legrandeco', 'debug', 'Information non existante, création');
          $newLegrand = new legrandecoCmd();
          $newLegrand->setEqLogic_id($this->getId());
          $newLegrand->setEqType('legrandeco');
          $newLegrand->setIsVisible(1);
          $newLegrand->setIsHistorized(0);
          $newLegrand->setSubType('numeric');
          $newLegrand->setLogicalId($name);
          $newLegrand->setType('info');
          $newLegrand->setName( 'Teleinfo - ' . $text );
          $newLegrand->setConfiguration('name', $name);
          $newLegrand->setConfiguration('value', $value);
          $newLegrand->setConfiguration('type', 'teleinfo');
          $newLegrand->save();
          $newLegrand->event($value);
        } else {
          $cmdlogic->setConfiguration('value', $value);
          $cmdlogic->setConfiguration('type', 'teleinfo');
          $cmdlogic->save();
          $cmdlogic->event($value);
        }
    }
  }
}

public function searchValue($html, $name) {
  $value = '';
  $lines = explode("\n", $html);
  foreach($lines as $line)
  {
    if (strpos($line, $name. ' = ') !== false && strpos($line, 'parseInt') == false && strpos($line, 'reponse.data') == false)
    {
      $value = str_replace($name. ' = ', '', trim($line));
      $value = substr($value, 0, strpos($value, ';'));
      $value = str_replace('var ', '', $value);
      $value = str_replace('setNull(', '', $value);
      $value = str_replace('.toFixed(2)', '', $value);
      $value = trim($value, '"');
      $value = trim($value, ')');

      break;
    }
  }
  return $value;
}

public function getData() {
  $addr = $this->getConfiguration('addr', '');
  $devAddr = 'http://' . $addr . '/data.json';
  $devResult = legrandeco::curl_get_file_contents($devAddr);
  log::add('legrandeco', 'debug', 'getInformations ' . $devAddr);
  if ($devResult === false) {
    log::add('legrandeco', 'info', 'problème de connexion ' . $devAddr);
  } else {
    $devResbis = utf8_encode($devResult);
    $devList = json_decode($devResbis, true);
    log::add('legrandeco', 'debug', print_r($devList, true));
    if (json_last_error() == JSON_ERROR_NONE) {
      foreach($devList as $name => $value) {
        if (strpos($name,'type_imp') !== false || strpos($name,'label_entree') !== false || strpos($name,'entree_imp') !== false) {
          // pas de traitement sur ces données
        } else {
          log::add('legrandeco', 'debug', 'Sonde trouvée : ' . $name . ', valeur ' . $value);
          $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($this->getId(),$name);
          if (!is_object($cmdlogic)) {
            log::add('legrandeco', 'debug', 'Information non existante, création');
            $newLegrand = new legrandecoCmd();
            $newLegrand->setEqLogic_id($this->getId());
            $newLegrand->setEqType('legrandeco');
            $newLegrand->setIsVisible(1);
            $newLegrand->setIsHistorized(0);
            $newLegrand->setSubType('numeric');
            $newLegrand->setLogicalId($name);
            $newLegrand->setType('info');
            $newLegrand->setName( 'Data - ' . $name );
            $newLegrand->setConfiguration('name', $name);
            $newLegrand->setConfiguration('value', $value);
            $newLegrand->setConfiguration('type', 'data');
            $newLegrand->save();
            $newLegrand->event($value);
          } else {
            $cmdlogic->setConfiguration('value', $value);
            $cmdlogic->setConfiguration('type', 'data');
            $cmdlogic->save();
            $cmdlogic->event($value);
          }
        }
      }
    }
  }
  $this->refreshWidget();
}

public function getConso($id) {
  $legrandeco = eqLogic::byId($id);
  $addr = $legrandeco->getConfiguration('addr', '');
  $devAddr = 'http://' . $addr . '/LOG2.CSV';
  //$devResult = legrandeco::curl_get_file_contents($devAddr);
  $devResult = fopen($devAddr, "r");
  log::add('legrandeco', 'info', 'getConso ' . $devAddr);
  /*
  jour	mois	annee	heure	minute	energie_tele_info	prix_tele_info	energie_circuit1	prix_circuit1	energie_cirucit2	prix_circuit2	energie_circuit3	prix_circuit3	energie_circuit4	prix_circuit4	energie_circuit5	prix_circuit5	volume_entree1	volume_entree2	tarif	energie_entree1	energie_entree2	prix_entree1	prix_entree2
  17	8	15	20	2	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0	0.000	0.000	0.000	0.000
  17	8	15	21	2	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	0.000	11	0.000	0.000	0.000	0.000
  */
  if ($devResult === false) {
    log::add('legrandeco', 'info', 'problème de connexion ' . $devAddr);
  } else {
    while ( ($data = fgetcsv($devResult,1000,";") ) !== FALSE ) {
      $num = count($data);
      if ($data[0] == date('j') && $data[1] == date('n') && $data[2] == date('y') && $data[3] == date('G')) {
        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_tele_info');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_tele_info');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Teleinfo' );
          $cmdlogic->setConfiguration('name', 'Conso Teleinfo');
        }
        $cmdlogic->setConfiguration('value', $data[5]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[5]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_circuit1');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_circuit1');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Pince 1' );
          $cmdlogic->setConfiguration('name', 'Pince 1');
        }
        $cmdlogic->setConfiguration('value', $data[7]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[7]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_circuit2');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_circuit2');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Pince 2' );
          $cmdlogic->setConfiguration('name', 'Pince 2');
        }
        $cmdlogic->setConfiguration('value', $data[9]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[9]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_circuit3');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_circuit3');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Pince 3' );
          $cmdlogic->setConfiguration('name', 'Pince 3');
        }
        $cmdlogic->setConfiguration('value', $data[11]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[11]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_circuit4');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_circuit4');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Pince 4' );
          $cmdlogic->setConfiguration('name', 'Pince 4');
        }
        $cmdlogic->setConfiguration('value', $data[13]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[13]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_circuit5');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_circuit5');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Pince 5' );
          $cmdlogic->setConfiguration('name', 'Pince 5');
        }
        $cmdlogic->setConfiguration('value', $data[15]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[15]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'volume_entree1');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('volume_entree1');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Impulsion 1' );
          $cmdlogic->setConfiguration('name', 'Impulsion 1');
        }
        $cmdlogic->setConfiguration('value', $data[17]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[17]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'volume_entree2');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('volume_entree2');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Impulsion 2' );
          $cmdlogic->setConfiguration('name', 'Impulsion 2');
        }
        $cmdlogic->setConfiguration('value', $data[18]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[18]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_entree1');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_entree1');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Vol Impulsion 1' );
          $cmdlogic->setConfiguration('name', 'Vol Impulsion 1');
        }
        $cmdlogic->setConfiguration('value', $data[20]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[20]);

        $cmdlogic = legrandecoCmd::byEqLogicIdAndLogicalId($legrandeco->getId(),'energie_entree2');
        if (!is_object($cmdlogic)) {
          $cmdlogic = new legrandecoCmd();
          $cmdlogic->setEqLogic_id($legrandeco->getId());
          $cmdlogic->setEqType('legrandeco');
          $cmdlogic->setSubType('numeric');
          $cmdlogic->setLogicalId('energie_entree2');
          $cmdlogic->setType('info');
          $cmdlogic->setName( 'Conso - Vol Impulsion 2' );
          $cmdlogic->setConfiguration('name', 'Vol Impulsion 2');
        }
        $cmdlogic->setConfiguration('value', $data[21]);
        $cmdlogic->setConfiguration('type', 'csv');
        $cmdlogic->save();
        $cmdlogic->event($data[21]);
      }

    }
  }
}

public function curl_get_file_contents($URL)  {
  $c = curl_init();
  curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($c, CURLOPT_URL, $URL);
  $contents = curl_exec($c);
  curl_close($c);

  if ($contents) return $contents;
  else return false;
}


}

class legrandecoCmd extends cmd {
  public function execute($_options = null) {
    switch ($this->getType()) {
      case 'info' :
      return $this->getConfiguration('value');
      break;
    }

  }

}

?>
