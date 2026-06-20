<style>
    .contact-form {
        margin: 60px 0;
        font-family: "Segoe UI", sans-serif;
    }

    .inner-contact-form {
        padding: 30px;
        border: 2px solid #ddd;
        border-radius: 12px;
        box-shadow: 0px 8px 20px rgba(0, 0, 0, 0.08);
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 30px;
        background: #fff;
        transform: translateY(0);
        transition: all .5s ease-in-out
    }

    .inner-contact-form:hover {
        transform: translateY(-10px);
    }

    .contact-form-aside {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }

    .contact-form-aside h1 {
        font-size: 5rem;
        margin-bottom: 12px;
    }

    .contact-form-aside p {
        color: #4a5568;
        line-height: 1.6;
    }

    .contact-info {
        padding: 20px;
        background-color: #f3f6ff;
        border-radius: 12px;
    }

    .contact-item {
        display: flex;
        align-items: center;
        gap: 12px;
        color: #2d3748;
        font-size: 1rem;
        margin: 12px 0;
    }

    .contact-item>a {
        font-size: 1.6rem;
        color: #2d3748;
        text-align: left;
    }

    .contact-icon {
        width: 22px;
        height: 22px;
        color: #4c6ef5;
        flex-shrink: 0;
    }

    /* FORM SIDE */
    .contact-form-bside form {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: 0px;
    }

    .form-group label {
        font-size: 1.6rem;
        color: #4a5568;
        font-weight: 500;
    }

    .form-group input,
    .form-group textarea {
        padding: 12px 14px;
        border: 1px solid #cbd5e0;
        border-radius: 8px !important;
        font-size: 1rem;
        outline: none;
        transition: all 0.3s ease;
    }

    .form-group input:focus,
    .form-group textarea:focus {
        border-color: #4c6ef5;
        box-shadow: 0px 0px 6px rgba(76, 110, 245, 0.3);
    }

    .form-group textarea {
        resize: none;
        min-height: 120px;
        color: #000 !important;
    }

    .submit-btn {
        padding: 14px;
        border: none;
        border-radius: 8px;
        font-size: 1.6rem;
        font-weight: 600;
        cursor: pointer;
        background: linear-gradient(135deg, #4c6ef5, #6875f5);
        color: #fff;
        transition: transform 0.2s ease, box-shadow 0.3s ease;
    }

    .submit-btn:hover:not(:disabled) {
        transform: translateY(-2px);
        box-shadow: 0 6px 15px rgba(76, 110, 245, 0.3);
    }

    .submit-btn:disabled {
        cursor: not-allowed;
        opacity: 0.8;
    }

    .submit-btn.is-loading {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .submit-btn.is-loading::before {
        content: "";
        width: 18px;
        height: 18px;
        border: 3px solid rgba(255, 255, 255, 0.45);
        border-top-color: #fff;
        border-radius: 50%;
        animation: contactButtonLoader 0.8s linear infinite;
    }

    .form-status {
        display: none;
        margin-top: 4px;
        font-size: 1.4rem;
        font-weight: 600;
    }

    .form-status.success {
        display: block;
        color: #16803c;
    }

    .form-status.error {
        display: block;
        color: #c53030;
    }

    @keyframes contactButtonLoader {
        to {
            transform: rotate(360deg);
        }
    }

    /* RESPONSIVE */
    @media(max-width: 768px) {
        .inner-contact-form {
            grid-template-columns: 1fr;
            padding: 20px;
        }
    }
</style>

<section class="contact-form">
    <h1 class="hover-heading">CONTACT US</h1>

    <div class="container">
        <div class="inner-contact-form">
            <!-- LEFT SIDE -->
            <div class="contact-form-aside">
                <div>
                    <h1 style="color:black;">Get in Touch</h1>
                    <p>We’d love to hear from you! 🌾<br />
                        At <strong>Bhau Poha</strong>, we’re committed to bringing you purity and freshness from farm to table. Whether you have a question, feedback, or just want to connect — our team is here to help.</p>
                </div>

                <div class="contact-info">
                    <div class="contact-item">
                        <svg class="contact-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                            <path
                                d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                        </svg>
                        <a href="mailto:mahadevfoods1998@gmail.com">mahadevfoods1998@gmail.com</a>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                        </svg>
                        <a href="tel:918889536631">+91-8889536631</a>
                    </div>
                    <div class="contact-item">
                        <svg class="contact-icon" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z"
                                clip-rule="evenodd" />
                        </svg>
                        <a href="https://maps.app.goo.gl/rLHvtXDQcnq4WxuL7" target="_blank">Mahadev Foods, khokhali Bhatapara (C.G), 493118</a>
                    </div>
                </div>
            </div>

            <!-- RIGHT SIDE (FORM) -->
            <div class="contact-form-bside">
                <form id="contactForm" method="POST" action="send-email.php">

                    <div class="form-group">
                        <label for="name">Full Name</label>
                        <input
                            id="name"
                            name="name"
                            type="text"
                            placeholder="Enter your name"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input
                            id="phone"
                            name="number"
                            type="tel"
                            placeholder="7986545XXX"
                            maxlength="10"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea
                            id="message"
                            name="message"
                            placeholder="Write your message here..."></textarea>
                    </div>

                    <button type="submit" class="submit-btn" id="contactSubmitBtn">
                        Send Message
                    </button>
                    <div class="form-status" id="contactFormStatus" aria-live="polite"></div>

                </form>
            </div>
        </div>
    </div>
</section>

<script>
    const contactForm = document.getElementById("contactForm");
    const contactSubmitBtn = document.getElementById("contactSubmitBtn");
    const contactFormStatus = document.getElementById("contactFormStatus");
    const defaultSubmitText = contactSubmitBtn.textContent.trim();

    contactForm.addEventListener("submit", async function(e) {
        e.preventDefault();

        contactFormStatus.textContent = "";
        contactFormStatus.className = "form-status";
        contactSubmitBtn.disabled = true;
        contactSubmitBtn.classList.add("is-loading");
        contactSubmitBtn.textContent = "Sending...";

        try {
            const response = await fetch(this.action, {
                method: "POST",
                body: new FormData(this)
            });

            let result = null;
            const contentType = response.headers.get("content-type") || "";

            if (contentType.includes("application/json")) {
                result = await response.json();
            } else {
                result = await response.text();
            }

            if (!response.ok || (result && result.status === "error")) {
                throw new Error((result && result.message) || "Unable to send message. Please try again.");
            }

            contactFormStatus.textContent = "Message sent successfully!";
            contactFormStatus.classList.add("success");
            this.reset();
        } catch (error) {
            contactFormStatus.textContent = error.message || "Unable to send message. Please try again.";
            contactFormStatus.classList.add("error");
        } finally {
            contactSubmitBtn.disabled = false;
            contactSubmitBtn.classList.remove("is-loading");
            contactSubmitBtn.textContent = defaultSubmitText;
        }
    });
</script>
