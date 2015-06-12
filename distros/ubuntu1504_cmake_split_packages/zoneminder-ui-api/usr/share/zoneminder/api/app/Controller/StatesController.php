<?php
App::uses('AppController', 'Controller');
/**
 * States Controller
 *
 * @property State $State
 * @property PaginatorComponent $Paginator
 */

class StatesController extends AppController {

public $components = array('RequestHandler');

/**
 * index method
 *
 * @return void
 */
	public function index() {
		$this->State->recursive = 0;
        	$states = $this->State->find('all');
        	$this->set(array(
        	    'states' => $states,
        	    '_serialize' => array('states')
        	));
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->State->exists($id)) {
			throw new NotFoundException(__('Invalid state'));
		}
		$options = array('conditions' => array('State.' . $this->State->primaryKey => $id));
		$this->set('state', $this->State->find('first', $options));
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->State->create();
			if ($this->State->save($this->request->data)) {
				return $this->flash(__('The state has been saved.'), array('action' => 'index'));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->State->exists($id)) {
			throw new NotFoundException(__('Invalid state'));
		}
		if ($this->request->is(array('post', 'put'))) {
			if ($this->State->save($this->request->data)) {
				return $this->flash(__('The state has been saved.'), array('action' => 'index'));
			}
		} else {
			$options = array('conditions' => array('State.' . $this->State->primaryKey => $id));
			$this->request->data = $this->State->find('first', $options);
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->State->id = $id;
		if (!$this->State->exists()) {
			throw new NotFoundException(__('Invalid state'));
		}
		$this->request->allowMethod('post', 'delete');
		if ($this->State->delete()) {
			return $this->flash(__('The state has been deleted.'), array('action' => 'index'));
		} else {
			return $this->flash(__('The state could not be deleted. Please, try again.'), array('action' => 'index'));
		}
	}

	public function change() {
		$newState = $this->request->params['pass'][0];
		$blah = $this->packageControl($newState);

		$this->set(array(
			'blah' => $blah,
			'_serialize' => array('blah')
		));
	}

	public function packageControl( $command ) {
		$zm_path_bin = Configure::read('ZM_PATH_BIN');
		$string = $zm_path_bin.'/zmpkg.pl '.escapeshellarg( $command );
		$status = exec( $string );

		return $status;
	}


}
