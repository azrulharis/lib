<?php
/**
 * Bake Template for Controller action generation.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.actions
 * @since         CakePHP(tm) v 1.3
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
?>

/**
 * <?php echo $admin ?>constructor
 *  
 * @return void
 */
	public function beforeFilter() {
		parent::beforeFilter();
		$this->Auth->allow('index', 'add', 'edit', 'view', 'verify_index', 'verify_view', 'printing');
	} 

/**
 * <?php echo $admin ?>index method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */ 	
	public function <?php echo $admin ?>index() { 
		$conditions = array();
		if(isset($_GET['search'])) {
			if($_GET['name'] != '') {
				$conditions['<?php echo $currentModelName; ?>.name LIKE'] = '%' . $_GET['name'] . '%';
			}

			if($_GET['date_from'] != '') {
				$conditions['<?php echo $currentModelName; ?>.created >='] = $_GET['date_from'];
			}

			if($_GET['date_to'] != '') {
				$conditions['<?php echo $currentModelName; ?>.created <='] = $_GET['date_to'];
			}

			if($_GET['name'] != '') {
				$conditions['<?php echo $currentModelName; ?>.name LIKE'] = '%' . $_GET['name'] . '%';
			}

			$this->request->data['<?php echo $currentModelName; ?>'] = $_GET;
		}

		$conditions['<?php echo $currentModelName; ?>.group_id'] = $this->group_id;
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'order' => '<?php echo $currentModelName; ?>.id DESC'
		);

		$this->set('<?php echo $pluralName ?>', $this->Paginator->paginate());
	}

/**
 * verify_index method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */ 	
	public function verify_index() {
		$conditions = array();
		if(isset($_GET['search'])) {
			if($_GET['name'] != '') {
				$conditions['<?php echo $currentModelName; ?>.name LIKE'] = '%' . $_GET['name'] . '%';
			}

			if($_GET['date_from'] != '') {
				$conditions['<?php echo $currentModelName; ?>.created >='] = $_GET['date_from'];
			}

			if($_GET['date_to'] != '') {
				$conditions['<?php echo $currentModelName; ?>.created <='] = $_GET['date_to'];
			}

			if($_GET['name'] != '') {
				$conditions['<?php echo $currentModelName; ?>.name LIKE'] = '%' . $_GET['name'] . '%';
			}

			$this->request->data['<?php echo $currentModelName; ?>'] = $_GET;
		}

		$conditions['<?php echo $currentModelName; ?>.group_id'] = $this->group_id;
		$this-><?php echo $currentModelName ?>->recursive = 0;
		$this->Paginator->settings = array(
			'conditions' => $conditions,
			'order' => '<?php echo $currentModelName; ?>.id DESC'
		);

		$this->set('<?php echo $pluralName ?>', $this->Paginator->paginate());
	}

/**
 * <?php echo $admin ?>view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */ 
	public function <?php echo $admin ?>view($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->find('first', $options));
	}

/**
 * verify_view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */ 
	public function verify_view($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
		$this->set('<?php echo $singularName; ?>', $this-><?php echo $currentModelName; ?>->find('first', $options));
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>add method
 *
 * @return void
 */
	public function <?php echo $admin ?>add() {
		if ($this->request->is('post')) {
			$this-><?php echo $currentModelName; ?>->create();

			$ar = $this-><?php echo $currentModelName; ?>->find('first', array(  
                'recursive' => -1,
                'order' => '<?php echo $currentModelName; ?>.id DESC'
                ));
            $prefix = 'ABC';  
            if($ar) {
                $no = preg_replace('/[^0-9.]+/', '', $ar['AssetRequest']['name']);
                $no = $no + 1;  
            } else {
                $no = 1;
            }    
            $name = $this->generate_code($prefix, $no);
            $this->request->data['<?php echo $currentModelName; ?>']['name'] = $name;
			$this->request->data['<?php echo $currentModelName; ?>']['created'] = $this->date;
			$this->request->data['<?php echo $currentModelName; ?>']['user_id'] = $this->user_id;
			$this->request->data['<?php echo $currentModelName; ?>']['group_id'] = $this->group_id;
			$this->request->data['<?php echo $currentModelName; ?>']['modified'] = '';
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {
				$id = $this-><?php echo $currentModelName; ?>->getLastInsertId();

<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), 'success');
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please, try again.'), 'error');
<?php else: ?>
				return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			}
		}
<?php
	foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
		foreach ($modelObj->{$assoc} as $associationName => $relation):
			if (!empty($associationName)):
				$otherModelName = $this->_modelName($associationName);
				$otherPluralName = $this->_pluralName($associationName);
				echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
				$compact[] = "'{$otherPluralName}'";
			endif;
		endforeach;
	endforeach;
	if (!empty($compact)):
		echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
	endif;
?>
	}

<?php $compact = array(); ?>
/**
 * <?php echo $admin ?>edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>edit($id = null) {
		if (!$this-><?php echo $currentModelName; ?>->exists($id)) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$this->request->data['<?php echo $currentModelName; ?>']['modified'] = $this->date;
			if ($this-><?php echo $currentModelName; ?>->save($this->request->data)) {

				$name = 'Edit <?php echo $currentModelName; ?>';
		        $link = '/view/' . $id;
		        $type = 'Edit <?php echo $currentModelName; ?>';

		        $this->insert_log($this->user_id, $name, $link, $type);

<?php if ($wannaUseSession): ?>
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), 'success');
				return $this->redirect(array('action' => 'view', $id));
			} else {
				$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be saved. Please try again.'), 'error');
<?php else: ?>
				return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been saved.'), array('action' => 'index'));
<?php endif; ?>
			}
		} else {
			$options = array('conditions' => array('<?php echo $currentModelName; ?>.' . $this-><?php echo $currentModelName; ?>->primaryKey => $id));
			$this->request->data = $this-><?php echo $currentModelName; ?>->find('first', $options);
		}
<?php
		foreach (array('belongsTo', 'hasAndBelongsToMany') as $assoc):
			foreach ($modelObj->{$assoc} as $associationName => $relation):
				if (!empty($associationName)):
					$otherModelName = $this->_modelName($associationName);
					$otherPluralName = $this->_pluralName($associationName);
					echo "\t\t\${$otherPluralName} = \$this->{$currentModelName}->{$otherModelName}->find('list');\n";
					$compact[] = "'{$otherPluralName}'";
				endif;
			endforeach;
		endforeach;
		if (!empty($compact)):
			echo "\t\t\$this->set(compact(".join(', ', $compact)."));\n";
		endif;
	?>
	}

/**
 * <?php echo $admin ?>delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function <?php echo $admin; ?>delete($id = null) {
		$this-><?php echo $currentModelName; ?>->id = $id;
		if (!$this-><?php echo $currentModelName; ?>->exists()) {
			throw new NotFoundException(__('Invalid <?php echo strtolower($singularHumanName); ?>'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this-><?php echo $currentModelName; ?>->delete()) {
<?php if ($wannaUseSession): ?>
			$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> has been deleted.'), 'success');
		} else {
			$this->Session->setFlash(__('The <?php echo strtolower($singularHumanName); ?> could not be deleted. Please, try again.'), 'error');
		}
		return $this->redirect(array('action' => 'index'));
<?php else: ?>
			return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The <?php echo strtolower($singularHumanName); ?> could not be deleted. Please, try again.'), array('action' => 'index'));
		}
<?php endif; ?>
	}
