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

/* * ***************************Includes********************************* */
require_once dirname(__FILE__) . '/../../../../core/php/core.inc.php';

class legrandeco extends eqLogic {
  /*     * *************************Attributs****************************** */


  /*     * ***********************Methode static*************************** */


  public static function cron() {
    foreach (eqLogic::byType('legrandeco',true) as $legrandeco) {
      if ($legrandeco->getIsEnable() == 1 ) {
        $legrandeco->getInformations();
        $mc = cache::byKey('legrandecoWidgetdashboard' . $legrandeco->getId());
        $mc->remove();
        $mc = cache::byKey('legrandecoWidgetmobile' . $legrandeco->getId());
        $mc->remove();
        $legrandeco->toHtml('dashboard');
        $legrandeco->toHtml('mobile');
        $legrandeco->refreshWidget();
      }
    }

  }

  public static function cronHourly() {
    foreach (eqLogic::byType('legrandeco',true) as $legrandeco) {
      $legrandeco->getConso();
    }

  }


  /*     * *********************Methode d'instance************************* */

  public function preUpdate() {
    if ($this->getConfiguration('addr') == '') {
      throw new Exception(__('L\'adresse ne peut être vide',__FILE__));
    }
  }

  /*     * **********************Getteur Setteur*************************** */

  public function toHtml($_version = 'dashboard') {

    $mc = cache::byKey('legrandecoWidget' . $_version . $this->getId());
    if ($mc->getValue() != '') {
      return $mc->getValue();
    }
    if ($this->getIsEnable() != 1) {
            return '';
        }
        if (!$this->hasRight('r')) {
            return '';
        }
        $_version = jeedom::versionAlias($_version);
        if ($this->getDisplay('hideOn' . $_version) == 1) {
            return '';
        }
        $vcolor = 'cmdColor';
        if ($_version == 'mobile') {
            $vcolor = 'mcmdColor';
        }
        $parameters = $this->getDisplay('parameters');
        $cmdColor = ($this->getPrimaryCategory() == '') ? '' : jeedom::getConfiguration('eqLogic:category:' . $this->getPrimaryCategory() . ':' . $vcolor);
        if (is_array($parameters) && isset($parameters['background_cmd_color'])) {
            $cmdColor = $parameters['background_cmd_color'];
        }

        if (($_version == 'dview' || $_version == 'mview') && $this->getDisplay('doNotShowNameOnView') == 1) {
            $replace['#name#'] = '';
            $replace['#object_name#'] = (is_object($object)) ? $object->getName() : '';
        }
        if (($_version == 'mobile' || $_version == 'dashboard') && $this->getDisplay('doNotShowNameOnDashboard') == 1) {
            $replace['#name#'] = '<br/>';
            $replace['#object_name#'] = (is_object($object)) ? $object->getName() : '';
        }

        if (is_array($parameters)) {
            foreach ($parameters as $key => $value) {
                $replace['#' . $key . '#'] = $value;
            }
        }
    $background=$this->getBackgroundColor($_version);
    $replace = array(
      '#name#' => $this->getName(),
      '#id#' => $this->getId(),
      '#background_color#' => $background,
      '#height#' => $this->getDisplay('height', 'auto'),
      '#width#' => $this->getDisplay('width', '200px'),
      '#eqLink#' => ($this->hasRight('w')) ? $this->getLinkToConfiguration() : '#',
    );

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

    $replace['#name#'] = $this->getName();
    $replace['#id#'] = $this->getId();
    $replace['#collectDate#'] = '';
    $replace['#background_color#'] = $this->getBackgroundColor(jeedom::versionAlias($_version));
    $replace['#eqLink#'] = $this->getLinkToConfiguration();

    $parameters = $this->getDisplay('parameters');
    if (is_array($parameters)) {
      foreach ($parameters as $key => $value) {
        $replace['#' . $key . '#'] = $value;
        log::add('legrandeco', 'debug', $key . ' ' . $value);
      }
    } else {
      log::add('legrandeco', 'debug', 'widget param');
    }
    $html = template_replace($replace, getTemplate('core', $_version, 'legrandeco', 'legrandeco'));
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
            $newLegrand->setName( $name );
            $newLegrand->setConfiguration('name', $name);
            $newLegrand->setConfiguration('value', $value);
            $newLegrand->save();
            $newLegrand->event($value);
          } else {
            $cmdlogic->setConfiguration('value', $value);
            $cmdlogic->save();
            $cmdlogic->event($value);
          }
        }
      }
    }
  }

  public function getConso() {
    $addr = $this->getConfiguration('addr', '');
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
        log::add('legrandeco', 'info', 'getConso ' . $num);
      }
    }
  }

  public function curl_get_file_contents($URL)
  {
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
      log::add('legrandeco', 'debug', 'value ' . $this->getConfiguration('value'));
      break;
    }

  }

}

?>
