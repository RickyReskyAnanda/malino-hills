<section id="section_form" class="relative lines-deco">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 offset-lg-3">
                            <div id="success_message" class="text-center">
                                <h2>Your reservation has been sent successfully.</h2>
                                <div class="col-lg-8 offset-lg-2">
                                    <p>We will contact you shortly. Refresh this page if you want to make another reservation.</p>

                                    <img src="images/misc/2.webp" class="w-100 rounded-up-100" alt="">
                                </div>
                            </div>

                            <div id="booking_form">
                                <form name="contactForm" id='contact_form' class="form-border" method="post">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <h4>Choose Date</h4>                                        
                                            <input type="text" id="date-picker" class="form-control mb-4" name="date" value="">

                                            <div class="guests-n-rooms mb-4">
                                                <div class="row g-4">
                                                    <div class="col-md-4">
                                                        <div class="text-center border-1 pt-2">
                                                            <h4>Adult</h4>
                                                            <div class="de-number">
                                                                <span class="d-minus">-</span>
                                                                <input type="text" class="no-border no-bg" value="1">
                                                                <span class="d-plus">+</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-center border-1 pt-2">
                                                            <h4>Children</h4>
                                                            <div class="de-number">
                                                                <span class="d-minus">-</span>
                                                                <input type="text" class="no-border no-bg" value="0">
                                                                <span class="d-plus">+</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="text-center border-1 pt-2">
                                                            <h4>Room</h4>
                                                            <div id="d-room-count" class="de-number">
                                                                <span class="d-minus">-</span>
                                                                <input id="room-count" type="text" class="no-border no-bg" value="1">
                                                                <span class="d-plus">+</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="select-room">
                                        <h4>Select Room</h4>

                                        <select name="Room Type" class="room-type form-control">
                                        @foreach($rooms as $room)
                                          <option value="{{ $room['name'] }}" data-src="{{ $room['link'] }} ">
                                            {{ $room['name'] }} | -/night | 2 Guests
                                          </option>
                                          @endforeach
                                      
                                        </select>
                                    </div>

                                    <div id="step-2" class="row">
                                        <h4>Enter your details</h4>

                                        <div class="col-md-6">
                                            <div id='name_error' class='error'>Please enter your name.</div>
                                            <div>
                                                <input type='text' name='Name' id='name' class="form-control" placeholder="Your Name" required>
                                            </div>

                                            <div id='email_error' class='error'>Please enter your valid E-mail ID.</div>
                                            <div>
                                                <input type='email' name='Email' id='email' class="form-control" placeholder="Your Email" required>
                                            </div>

                                            <div id='phone_error' class='error'>Please enter your phone number.</div>
                                            <div>
                                                <input type='text' name='phone' id='phone' class="form-control" placeholder="Your Phone" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <textarea name='message' id='message' class="form-control" placeholder="Your Message"></textarea>
                                        </div>

                                        <div class="col-md-12">
                                            <div class="g-recaptcha" data-sitekey="6LdW03QgAAAAAJko8aINFd1eJUdHlpvT4vNKakj6"></div>
                                            <p id='submit' class="mt20">
                                                <input type='submit' id='send_message' value='Submit Form' class="btn-main">
                                            </p>
                                        </div>
                                    </div>
                                </form>
                                <div id='error_message' class='error'>Sorry, error occured this time sending your message.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>