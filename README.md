# ETS_PPLBO_35
Nama  : Aqil Rahman<br />
NIM   : 201524035<br />
Kelas : 3B - DIV<br />

## Service
* Products Port 8000
* Orders Port 8001
* Payment Port 8002
* Reporting Port 8003

## Contoh Penggunaan
Menampilkan data cukup dengan menggunakan method `GET` pada setiap service
```
http://localhost:8000/api/v1/products/
http://localhost:8001/api/v1/orders/
http://localhost:8002/api/v1/paymment/
http://localhost:8003/api/v1/sales-report/

/* Tambahkan parameter id untuk mendapatkan data berdasarkan id */
http://localhost:8000/api/v1/products/1

/* Tambahkan parameter id_pembayaran untuk mendapatkan data berdasarkan id */
http://localhost:8003/sales-report/1
```

### Product
Membuat product gunakan endpoint
```
http://localhost:8000/api/v1/products/
```
Isi form
* name_product
* price
* stock
* image

Melakukan perubahan data product tambahkan parameter `update/$id` pada endpoint

```
http://localhost:8000/api/v1/products/update/1
```
Ubah minimal salah satu:
* name_product
* price
* stock
* image

Menghapus data Product cukup dengan menggunakan Method `DELETE` kemudian tambahkan parameter product yang ingin dihapus
```
http://localhost:8000/api/v1/products/1
```
### Orders dan Payment
Membuat sebuah pesanan (orders) cukup dengan menggunakan Method `POST` dengan Endpoint 
```
http://localhost:8001/api/v1/orders/
```
Tentukan `id_product` dan `qty` yang dipesan kemudian akan melakukan trigger ke service `product` untuk mengurangi jumlah stok tersedia dan sevice `payment` untuk melakukan pembayaran terhadap pesanan
