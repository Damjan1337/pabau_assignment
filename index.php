<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <section class="hero">
            <h2>Welcome to Our Company</h2>
            <p>We provide exceptional services to meet your needs.</p>
        </section>

        <section class="about">
            <h2>About Us</h2>
            <p>We are a dedicated team of professionals committed to delivering high-quality solutions. Our mission is to provide innovative services that help our clients achieve their goals.</p>
            <p>With years of experience in the industry, we have developed a deep understanding of our clients' needs and how to address them effectively.</p>
        </section>

        <section class="lead-form-section">
            <h2>Contact Us</h2>
            <div id="form-response"></div>
            <form id="lead-form" class="lead-form">
                <div class="form-group">
                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" required>
                </div>
                <div class="form-group">
                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="mobile">Mobile</label>
                    <input type="tel" id="mobile" name="mobile" required>
                </div>
                <div class="form-group">
                    <label for="treatment_interest">Service Interest</label>
                    <select id="treatment_interest" name="treatment_interest">
                        <option value="">Select a service</option>
                        <option value="Consultation">Consultation</option>
                        <option value="Treatment">Treatment</option>
                        <option value="Information">Information</option>
                    </select>
                </div>
                <div class="form-group checkbox-group">
                    <input type="checkbox" id="opt_email" name="opt_email" value="1">
                    <label for="opt_email">Subscribe to email updates</label>
                </div>
                <button type="submit" class="submit-btn">Submit</button>
            </form>
        </section>
    </div>
</main>

<?php get_footer(); ?>