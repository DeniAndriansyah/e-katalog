<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Order extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Base_m');
        $this->load->model('Order_m');
    }

    public function index()
    {
        $order = $this->Base_m->all('order');
        $data = [
            'title' => 'Order',
            'orders' => $order,
        ];

        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/order/index', $data);
        $this->load->view('component/admin/footer');
    }

    public function add()
    {
        $data = [
            'title' => 'Add Order',
            'products' => $this->Base_m->all('product'),
        ];
        $this->load->view('component/admin/header', $data);
        $this->load->view('component/admin/sidebar');
        $this->load->view('pages/admin/order/add', $data);
        $this->load->view('component/admin/footer');
    }

    public function detail($order_id)
    {
        // Ambil detail pesanan berdasarkan ID
        $order_detail = $this->Order_m->get_order_details($order_id);
        $order = $this->Order_m->get_order_by_id($order_id);

        if (!$order_detail) {
            echo '<p>Order not found!</p>';
            return;
        }

        // Ambil data struk (receipt) sesuai dengan order
        $receipt = $this->load->view('pages/admin/order/receipt', ['order_detail' => $order_detail, 'order' => $order], true);

        // Kembalikan tampilan struk sebagai response (HTML)
        echo $receipt;
    }

    public function delete($id)
    {
        $this->Base_m->delete('order', $id);
        $this->session->set_flashdata('success', 'Order deleted successfully');
        redirect('order');
    }

    public function load_cart()
    {
        $cart = $this->session->userdata('cart') ?? [];
        echo json_encode(['cart' => array_values($cart)]);
    }

    public function add_to_cart()
    {
        $product_id = htmlspecialchars($this->input->post('product_id'));
        $product_name = htmlspecialchars($this->input->post('product_name'));
        $product_price = htmlspecialchars($this->input->post('product_price'));
        $quantity = htmlspecialchars($this->input->post('quantity'));
        $cart = $this->session->userdata('cart') ?? [];

        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity'] += $quantity;
            $cart[$product_id]['subtotal'] = $cart[$product_id]['quantity'] * $cart[$product_id]['price'];
        } else {
            $cart[$product_id] = [
                'product_id' => $product_id,
                'name' => $product_name,
                'price' => $product_price,
                'quantity' => $quantity,
                'subtotal' => $product_price * $quantity,
            ];
        }

        $this->session->set_userdata('cart', $cart);
        echo json_encode(['success' => true]);
    }

    public function remove_from_cart()
    {
        $product_id = htmlspecialchars($this->input->post('product_id'));
        $cart = $this->session->userdata('cart') ?? [];

        if (isset($cart[$product_id])) {
            unset($cart[$product_id]);
            $this->session->set_userdata('cart', $cart);
        }

        echo json_encode(['success' => true]);
    }

    public function place_order()
    {
        $table_number = htmlspecialchars($this->input->post('table_number'));
        $customer_name = htmlspecialchars($this->input->post('customer_name'));
        $cart = $this->session->userdata('cart') ?? [];

        if (empty($cart)) {
            echo json_encode(['success' => false, 'message' => 'Keranjang kosong!']);
            return;
        }

        $order_data = [
            'table_number' => $table_number,
            'customer_name' => $customer_name,
            'order_date' => date('Y-m-d'),
            'status' => 'diproses',
        ];

        $order_id = $this->Order_m->insert_order($order_data);

        foreach ($cart as $item) {
            $order_detail = [
                'order_id' => $order_id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['subtotal'],
            ];
            $this->Order_m->insert_order_detail($order_detail);
        }

        $this->session->unset_userdata('cart');
        echo json_encode(['success' => true, 'message' => 'Pesanan berhasil disimpan!']);
    }

    public function update_cart()
    {
        // Mendapatkan data dari request
        $product_id = htmlspecialchars($this->input->post('product_id'));
        $quantity = htmlspecialchars($this->input->post('quantity'));

        // Ambil cart yang ada di session
        $cart = $this->session->userdata('cart') ?? [];

        // Cek apakah product_id ada di dalam cart
        if (isset($cart[$product_id])) {
            // Jika ada, update quantity dan subtotal
            $cart[$product_id]['quantity'] = $quantity;
            $cart[$product_id]['subtotal'] = $cart[$product_id]['quantity'] * $cart[$product_id]['price'];

            // Simpan kembali cart ke session
            $this->session->set_userdata('cart', $cart);

            // Return response
            echo json_encode(['success' => true, 'message' => 'Cart updated successfully']);
        } else {
            // Jika produk tidak ada dalam cart
            echo json_encode(['success' => false, 'message' => 'Product not found in cart']);
        }
    }

}
