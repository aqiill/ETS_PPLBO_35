# Build Cafe Microservices With Lumen Laravel
## _ETS_PPLBO_35_
### Aqil Rahman 3B-D4TI

[![Build Status](https://img.shields.io/badge/develop-initial-purple)]()

Cafe Microservice menggunakan Lumen Laravel guna untuk memenuhi tugas Evaluasi Tengah Semester pada mata kuliah PPLBO tahun 2023<br>
Adapun Teknologi yang digunakan:<br>
* Lumen Laravel
* MySql

## Service
* API Gateway
* Discovery Service
* Products Service
* Orders Service
* Paymment Service
* Sales-report Service

## Rest API
Endpoint dan Method pada setiap service:
| Service | Method | endpoint |
| ------- | ------ | -------- |
| products | GET | http://localhost:8080/api/products |
| products | GET | http://localhost:8080/api/products/{id} |
| products | POST | http://localhost:8080/api/products |
| products | POST | http://localhost:8080/api/products/update/{id} |
| products | DELETE | http://localhost:8080/api/products/{ID} |
| orders | GET | http://localhost:8080/api/orders |
| orders | GET | http://localhost:8080/api/orders/{id} |
| orders | POST | http://localhost:8080/api/orders |
| orders | POST | http://localhost:8080/api/orders/update/{id} |
| orders | DELETE | http://localhost:8080/api/orders/{id} |
| payment | GET | http://localhost:8080/api/payment |
| payment | GET | http://localhost:8080/api/payment/{id} |
| payment | POST | http://localhost:8080/api/payment |
| payment | POST | http://localhost:8080/api/payment/update/{id} |
| sales-report | GET | http://localhost:8080/api/sales-report |
| sales-report | GET | http://localhost:8080/api/sales-report/{id} |

Tambahkan parameter id untuk mendapatkan data berdasarkan id
```
http://localhost:8000/api/v1/products/1
```
Tambahkan parameter id_pembayaran pada sales-report untuk mendapatkan detail laporan
```
http://localhost:8003/sales-report/1
```
## Product
Membuat product gunakan endpoint
```
http://localhost:8000/api/v1/products/
```
Field
* name_product
* price
* stock
* image

Melakukan perubahan data product tambahkan parameter `update/$id` pada endpoint

```
http://localhost:8000/api/v1/products/update/1
```
Ubah minimal salah satu field:
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
