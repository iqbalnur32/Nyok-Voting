## Tentang Aplikasi
Aplikasi Nyok Voting merupakan aplikasi E Vote yang di desain untuk membantu dalam pemilihan suara secara dinamis dan tepat

## Fitur Fitur
	- Login ( role = admin dan users )
	- Register 
	- Forgot Password
	- Personal Vote ( dimana kalian bisa membuat vote dengan 1 gambar saja, contoh kalian bisa melakukan pemilihan suara tentang karya anda, dll)
	- Multiple Vote ( dimana kalian bisa membuat vote lebih dari 2 ) => masa devolopment
	- Static Data Jawaban Vote ( fitur masih terdapat pada personal vote )
	- Quick Count ( masa devolopment )
	- Management Jawaban ( Admin )
	- Management Create Vote ( Admin )
	- Management Create Users ( Admin )
	- Management Category Vote ( Admin )
	- Data Monitoring ( Admin )

## Cara Instalasi Aplikasi
	- Download / Clone aplikasi ini
	- composer install
	- buat file .env terlebih dahulu copy file .env-example ke file .env
	- php artisan key:generate
	- buat database mysql sesuaikan nama database anda dalam file .env 
	- php artisan migrate
	- php artisan serve

## Cara Kerja Aplikasi
	Membuat Pemilihan Suara Personal Vote 
		- Register terlebih dahulu 
		- lalu Login dengan akun yang sudah di register
		- masuk menu Create Vote
		- di table sebelah kanan terdapat form add create 
		- isikan data data yang ingin di lakukan pemelihan
		- submit
		- ketika berhasil lihat di Voting Table, terdapat table
		- pilih button VOTE ID 
		- Copy ID VOTE ke teman teman kamu
		- pastikan teman teman kamu sudah terdaftar sebagai member Nyok Voting

	Melakukan Vote 
		- Login terlebih dahulu
		- lalu di menu Dashboard terdapat button "Ayok Voting !"
		- klik button tersebut, lalu muncul form copy ID VOTE anda lalu klick tombol Voting
		- setelah itu kamu akan di sediakan form untuk memilih jawaban anda apakah Setuju Atau Tidak Setuju
		- masing masing Users berhak memilih 1 kali saja dalam 1 ID VOTE

## Contact Devoloper
	iqbalnurw9@gmail.com => Gmail
	iqbalnur32 => Instagram


My Framework Laravel + Mysql + Argon Dashboard + Queue ( Technology Antrian Data )