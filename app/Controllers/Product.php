<?php namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\ProductModel;

class Product extends Controller
{
	public function index()
	{
		echo view('product_view');
	}

    public function getProduct()
    {
        $model = new ProductModel();
        $data = $model->findAll();
        return json_encode($data);
    }

    public function save(){
        $model = new ProductModel();
        $json = $this->request->getJSON();
        $data = [
            'product_name' => $json->product_name,
            'product_price' => $json->product_price
        ];
        $model->insert($data);
    }

    public function update($id = null){
        $model = new ProductModel();
        $json = $this->request->getJSON();
        $data = [
            'product_name' => $json->product_name,
            'product_price' => $json->product_price
        ];
        $model->update($id, $data);
    }

    public function delete($id = null){
        $model = new ProductModel();
        $model->delete($id);
    }

}
