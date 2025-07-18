<section class="">
   
    <div class="container">
        <div class="row justify-content-center">
            @if(request()->segment(1) == 'id')
            <div class="col-lg-8">
                <h1 class="text-center mb-4">Kebijakan Privasi</h1>
                <p><strong>Malino Hills Resort & Cafe</strong> berkomitmen untuk melindungi privasi Anda dan keamanan informasi pribadi yang Anda berikan saat menggunakan situs web kami. Kebijakan Privasi ini menjelaskan bagaimana kami mengumpulkan, menggunakan, dan melindungi informasi pribadi Anda.</p>

                <h3>1. Informasi yang Kami Kumpulkan</h3>
                <p>Kami dapat mengumpulkan berbagai informasi pribadi dari pengguna, termasuk namun tidak terbatas pada:</p>
                <ul>
                    <li>Nama lengkap</li>
                    <li>Alamat email</li>
                    <li>Nomor telepon</li>
                    <li>Alamat pengiriman atau lokasi</li>
                    <li>Informasi pembayaran (jika diperlukan untuk transaksi)</li>
                    <li>Data pengguna lainnya yang relevan dengan pemesanan atau penggunaan layanan</li>
                </ul>

                <h3>2. Bagaimana Kami Menggunakan Informasi Anda</h3>
                <p>Informasi yang kami kumpulkan digunakan untuk berbagai tujuan, termasuk namun tidak terbatas pada:</p>
                <ul>
                    <li>Mengelola dan mengonfirmasi pemesanan atau reservasi Anda</li>
                    <li>Berkomunikasi dengan Anda mengenai layanan yang Anda gunakan atau promosi khusus</li>
                    <li>Memproses transaksi dan pembayaran terkait layanan kami</li>
                    <li>Menyediakan layanan pelanggan yang lebih baik</li>
                    <li>Meningkatkan pengalaman pengguna di situs web kami</li>
                    <li>Mengirimkan informasi tentang produk, layanan, atau promosi terbaru kami, jika Anda telah menyetujui untuk menerima komunikasi tersebut</li>
                </ul>

                <h3>3. Keamanan Informasi</h3>
                <p>Kami melindungi informasi pribadi Anda menggunakan langkah-langkah teknis dan organisasi yang wajar untuk mencegah akses yang tidak sah, kehilangan, penyalahgunaan, atau penghancuran. Namun, kami tidak dapat sepenuhnya menjamin keamanan informasi yang dikirimkan melalui internet, dan Anda harus berhati-hati saat memberikan informasi secara online.</p>

                <h3>4. Pengungkapan kepada Pihak Ketiga</h3>
                <p>Kami tidak akan menjual, menyewakan, atau membagikan informasi pribadi Anda kepada pihak ketiga kecuali dalam keadaan berikut:</p>
                <ul>
                    <li>Diperlukan untuk menyelesaikan pemesanan atau transaksi, seperti penyedia layanan pembayaran atau pengiriman</li>
                    <li>Diminta oleh hukum, perintah pengadilan, atau otoritas pemerintah yang berwenang</li>
                    <li>Untuk melindungi hak, properti, atau keselamatan kami, pengguna kami, atau orang lain</li>
                </ul>

                <h3>5. Cookies dan Teknologi Pelacakan</h3>
                <p>Situs web kami menggunakan cookies dan teknologi pelacakan lainnya untuk meningkatkan pengalaman pengguna, menganalisis penggunaan situs, dan menyediakan konten yang sesuai dengan preferensi Anda. Anda dapat menonaktifkan cookies melalui pengaturan browser Anda, tetapi hal ini dapat memengaruhi fungsi situs kami.</p>

                <h3>6. Hak Anda</h3>
                <p>Sebagai pengguna, Anda memiliki hak-hak berikut terkait informasi pribadi Anda:</p>
                <ul>
                    <li><strong>Akses dan Koreksi:</strong> Anda berhak untuk meminta akses atau perbaikan terhadap informasi pribadi Anda yang kami miliki.</li>
                    <li><strong>Penghapusan:</strong> Anda berhak untuk meminta kami menghapus informasi pribadi Anda, kecuali jika diperlukan untuk memenuhi kewajiban hukum atau menyelesaikan transaksi.</li>
                    <li><strong>Pencabutan Persetujuan:</strong> Anda berhak untuk mencabut persetujuan Anda untuk menerima komunikasi pemasaran dari kami kapan saja dengan menghubungi kami menggunakan informasi kontak di bawah.</li>
                </ul>

                <h3>7. Perubahan Kebijakan Privasi</h3>
                <p>Kami berhak untuk mengubah Kebijakan Privasi ini dari waktu ke waktu. Setiap perubahan akan diposting di situs web kami dan akan berlaku segera setelah dipublikasikan. Kami menyarankan Anda untuk meninjau kebijakan ini secara berkala untuk tetap mendapatkan informasi tentang bagaimana kami melindungi informasi pribadi Anda.</p>

                <h3>8. Hubungi Kami</h3>
                <p>Jika Anda memiliki pertanyaan atau permintaan terkait Kebijakan Privasi ini, atau ingin mengakses, memperbarui, atau menghapus informasi pribadi Anda, silakan hubungi kami di:</p>
                <ul>
                    <li>Email: <a href="mailto:{{ $landingPageData['email'] }}">{{ $landingPageData['email'] }}</a></li>
                    <li>Telepon: +{{ $landingPageData['whatsapp'] }}</li>
                    <li>Alamat: {{ $landingPageData['address'] }}</li>
                </ul>
                <p class="text-muted">Kebijakan Privasi ini berlaku sejak {{ date('d/M/Y',strtotime('2024-01-01')) }}.</p>
            </div>
            @else
            <div class="col-lg-8">
                <h1 class="text-center mb-4">Privacy Policy</h1>
                <p><strong>Malino Hills Resort & Cafe</strong> is committed to protecting your privacy and the security of the personal information you provide when using our website. This Privacy Policy explains how we collect, use, and protect your personal information.</p>

                <h3>1. Information We Collect</h3>
                <p>We may collect various personal information from users, including but not limited to:</p>
                <ul>
                    <li>Full name</li>
                    <li>Email address</li>
                    <li>Phone number</li>
                    <li>Shipping address or location</li>
                    <li>Payment information (if required for transactions)</li>
                    <li>Other user data relevant to bookings or service use</li>
                </ul>

                <h3>2. How We Use Your Information</h3>
                <p>The information we collect is used for various purposes, including but not limited to:</p>
                <ul>
                    <li>Managing and confirming your bookings or reservations</li>
                    <li>Contacting you regarding the services you use or special promotions</li>
                    <li>Processing transactions and payments related to our services</li>
                    <li>Providing better customer service</li>
                    <li>Improving user experience on our website</li>
                    <li>Sending you information about our products, services, or latest promotions, if you have consented to receive such communications</li>
                </ul>

                <h3>3. Information Security</h3>
                <p>We protect your personal information using reasonable technical and organizational measures to safeguard against unauthorized access, loss, misuse, or destruction. However, we cannot fully guarantee the security of information transmitted over the internet, and you should exercise caution when providing information online.</p>

                <h3>4. Disclosure to Third Parties</h3>
                <p>We will not sell, rent, or share your personal information with third parties except under the following circumstances:</p>
                <ul>
                    <li>Required to complete a booking or transaction, such as payment or shipping service providers</li>
                    <li>Mandated by law, court order, or authorized governmental authorities</li>
                    <li>To protect the rights, property, or safety of us, our users, or others</li>
                </ul>

                <h3>5. Cookies and Tracking Technologies</h3>
                <p>Our website uses cookies and other tracking technologies to enhance user experience, analyze site usage, and provide content tailored to your preferences. You may disable cookies through your browser settings, but doing so may affect the functionality of our site.</p>

                <h3>6. Your Rights</h3>
                <p>As a user, you have the following rights regarding your personal information:</p>
                <ul>
                    <li><strong>Access and Correction:</strong> You have the right to request access to or correction of your personal information held by us.</li>
                    <li><strong>Deletion:</strong> You have the right to request that we delete your personal information, except where required to fulfill legal obligations or complete transactions.</li>
                    <li><strong>Withdrawal of Consent:</strong> You have the right to withdraw your consent to receive marketing communications from us at any time by contacting us using the contact information below.</li>
                </ul>

                <h3>7. Changes to the Privacy Policy</h3>
                <p>We reserve the right to modify this Privacy Policy from time to time. Any changes will be posted on our website and will take effect immediately upon publication. We encourage you to periodically review this policy to stay informed about how we protect your personal information.</p>

                <h3>8. Contact Us</h3>
                <p>If you have any questions or requests regarding this Privacy Policy or wish to access, update, or delete your personal information, please contact us at:</p>
                <ul>
                    <li>Email: <a href="mailto:{{ $landingPageData['email'] }}">{{ $landingPageData['email'] }}</a></li>
                    <li>Phone: +{{ $landingPageData['whatsapp'] }}</li>
                    <li>Address: {{ $landingPageData['address'] }}</li>
                </ul>
                <p class="text-muted">This Privacy Policy is effective as of {{ date('d/M/Y',strtotime('2024-01-01')) }}.</p>
            </div>
            @endif
        </div>
    </div>
</section>
