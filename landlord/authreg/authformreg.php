<main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 d-flex flex-column align-items-center justify-content-center">

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Register as a Landlord</h5>
                    <p class="text-center small">Enter your personal details to create an account</p>
                  </div>

                  <!-- Form -->
                  <form class="row g-3 needs-validation" method="POST" action="register_process.php" novalidate>
                    <div class="col-12">
                      <label for="firstName" class="form-label">First Name</label>
                      <input type="text" name="first_name" class="form-control" id="firstName" required>
                      <div class="invalid-feedback">Please enter your first name!</div>
                    </div>

                    <div class="col-12">
                      <label for="lastName" class="form-label">Last Name</label>
                      <input type="text" name="last_name" class="form-control" id="lastName" required>
                      <div class="invalid-feedback">Please enter your last name!</div>
                    </div>

                    <div class="col-12">
                      <label for="email" class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" id="email" required>
                      <div class="invalid-feedback">Please enter a valid email address!</div>
                    </div>

                    <div class="col-12">
                      <label for="password" class="form-label">Password</label>
                      <input type="password" name="password" class="form-control" id="password" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="phoneNumber" class="form-label">Phone Number</label>
                      <input type="text" name="phone_number" class="form-control" id="phoneNumber">
                      <div class="invalid-feedback">Please enter a valid phone number (optional).</div>
                    </div>

                    <div class="col-12">
                      <label for="address" class="form-label">Address</label>
                      <input type="text" name="address" class="form-control" id="address">
                      <div class="invalid-feedback">Please enter your address (optional).</div>
                    </div>

                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                            <label class="form-check-label" for="acceptTerms">
                            I agree and accept the <a href="#" data-bs-toggle="modal" data-bs-target="#termsModal">terms and conditions</a>
                            </label>
                            <div class="invalid-feedback">You must agree before submitting.</div>
                        </div>
                    </div>


                    <div class="col-12">
                      <button class="btn btn-primary w-100" type="submit">Register</button>
                    </div>

                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="/iBalay/landlord/authlog/login.php">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <!-- Terms and Conditions Modal -->
                <div class="modal fade" id="termsModal" tabindex="-1" role="dialog" aria-labelledby="termsModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="termsModalLabel">Terms and Conditions</h5>
                    </div>
                    <div class="modal-body">
                                    <!-- to be added more -->
                        <p>By registering, you agree to the following terms and conditions...</p>

                    </div>
                    <div class="modal-footer">
                         <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
                </div>


            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->