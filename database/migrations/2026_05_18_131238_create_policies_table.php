<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreatePoliciesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug')->unique();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->timestamps();
        });

        // Seed initial static HTML content from blade templates
        DB::table('policies')->insert([
            [
                'slug' => 'terms-condition',
                'title' => 'Terms & Conditions',
                'content' => <<<'HTML'
<p class="text-secondary lh-base">The terms "Ranayas", "We", "Us", "Our", and "Company" refer to Ranayas and/or Khushi Naturals. The terms "You", "Your", "Visitor", and "User" refer to any individual accessing or using this website.</p>
<p class="text-secondary lh-base">By accessing or using this website, you agree to comply with and be bound by the following Terms & Conditions. If you do not agree with these terms, please discontinue use of the website immediately.</p>
<p class="text-secondary lh-base">Ranayas reserves the right to modify, update, or revise these Terms & Conditions at any time without prior notice. Continued use of the website after changes are posted constitutes acceptance of those changes.</p>

<h4 class="mt-4 mb-2"><strong>Use of Website Content</strong></h4>
<p class="text-secondary lh-base">All content displayed on this website, including but not limited to logos, designs, trademarks, graphics, text, images, product descriptions, and other materials, are the property of Ranayas or are used with appropriate authorization.</p>
<p class="text-secondary lh-base">You may not copy, reproduce, republish, upload, distribute, transmit, or modify any content from this website for commercial purposes without prior written permission from Ranayas.</p>

<h4 class="mt-4 mb-2"><strong>Acceptable Use</strong></h4>
<p class="text-secondary lh-base">By using this website, you agree not to:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Violate or attempt to violate the security of the website.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Access data or accounts without authorization.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Attempt to interfere with the website's functionality through viruses, malware, flooding, or hacking.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Use the website for unlawful, harmful, defamatory, abusive, obscene, or fraudulent purposes.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Infringe upon the intellectual property or privacy rights of others.</li>
</ul>
<p class="text-secondary lh-base">Any violation may result in legal action and cooperation with law enforcement authorities.</p>

<h4 class="mt-4 mb-2"><strong>User Responsibilities</strong></h4>
<p class="text-secondary lh-base">You agree to provide accurate and complete information during registration or purchase. You are responsible for maintaining the confidentiality of your account information and password.</p>

<h4 class="mt-4 mb-2"><strong>Indemnification</strong></h4>
<p class="text-secondary lh-base">You agree to indemnify and hold harmless Ranayas, its directors, employees, partners, and affiliates against any claims, liabilities, damages, losses, or expenses arising from your misuse of the website or violation of these Terms & Conditions.</p>

<h4 class="mt-4 mb-2"><strong>Limitation of Liability</strong></h4>
<p class="text-secondary lh-base">Ranayas shall not be liable for any direct, indirect, incidental, consequential, or special damages arising out of:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Use or inability to use the website.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Unauthorized access to your data.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Errors, interruptions, or delays in website services.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Loss of profits, business, data, or goodwill.</li>
</ul>
<p class="text-secondary lh-base">Our maximum liability shall not exceed the amount paid by you for the relevant order or service.</p>

<h4 class="mt-4 mb-2"><strong>Children's Use</strong></h4>
<p class="text-secondary lh-base">This website is intended only for individuals capable of entering into legally binding contracts under the Indian Contract Act, 1872. Users under 18 years of age may use the website only under parental or guardian supervision.</p>

<h4 class="mt-4 mb-2"><strong>Jurisdiction</strong></h4>
<p class="text-secondary lh-base">These Terms & Conditions, Privacy Policy, Shipping Policy, Return & Refund Policy, and all transactions carried out through the Ranayas website and mobile applications (Android & iOS) shall be governed by and interpreted in accordance with the laws of India.</p>
<p class="text-secondary lh-base">Any disputes, claims, or legal proceedings arising out of the use of the website, mobile applications, products, services, or transactions shall be subject to the exclusive jurisdiction of the courts located in Mumbai, Maharashtra.</p>
HTML
                ,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'privacy',
                'title' => 'Privacy Policy',
                'content' => <<<'HTML'
<p class="text-secondary lh-base">At Ranayas, we are committed to protecting your privacy and safeguarding your personal information.</p>
<p class="text-secondary lh-base">This Privacy Policy applies to all users accessing or using the Ranayas website and mobile applications available on Android and iOS platforms.</p>
<p class="text-secondary lh-base">This policy explains how we collect, use, process, store, and protect your information when you interact with our platform, place orders, browse products, or contact customer support.</p>
<p class="text-secondary lh-base">By accessing or using the Ranayas website or mobile applications, you agree to the terms of this Privacy Policy.</p>

<h4 class="mt-4 mb-2"><strong>Information We Collect</strong></h4>
<p class="text-secondary lh-base">We may collect the following information from users:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Name</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Email address</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Phone number</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Shipping and billing address</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> PIN code</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Payment information</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Order history</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> IP address and browser details</li>
</ul>
<p class="text-secondary lh-base">This information helps us process orders, improve user experience, provide customer support, and communicate updates or offers.</p>

<h4 class="mt-4 mb-2"><strong>Cookies</strong></h4>
<p class="text-secondary lh-base">We may use cookies and similar technologies to:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Improve website functionality</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Personalize user experience</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Analyze website traffic</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Remember user preferences</li>
</ul>
<p class="text-secondary lh-base">Users may disable cookies through browser settings, though some features of the website may not function properly.</p>

<h4 class="mt-4 mb-2"><strong>Information Sharing</strong></h4>
<p class="text-secondary lh-base">We do not sell or rent your personal information to third parties. We may share information:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> With payment gateways and logistics partners for order processing.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> When required by law or government authorities.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> To protect our legal rights or prevent fraud.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Data Security</strong></h4>
<p class="text-secondary lh-base">We implement reasonable security measures to protect your personal information from unauthorized access, misuse, or disclosure. However, no method of internet transmission or storage is completely secure, and we cannot guarantee absolute security.</p>

<h4 class="mt-4 mb-2"><strong>Third-Party Links</strong></h4>
<p class="text-secondary lh-base">Currently, the Ranayas website and mobile applications (Android & iOS) do not intentionally provide third-party website links for external services or transactions. In case any third-party links, payment gateways, social media integrations, or external platforms are introduced in the future, Ranayas shall not be responsible for the privacy practices, policies, content, or security of such third-party websites or applications. Users are advised to review the respective privacy policies of external platforms before interacting with them.</p>

<h4 class="mt-4 mb-2"><strong>Changes to Privacy Policy</strong></h4>
<p class="text-secondary lh-base">We reserve the right to update this Privacy Policy at any time. Any changes will be posted on this page.</p>

<hr class="mt-5 mb-4">
<h4 class="mb-3"><strong>Contact Information</strong></h4>
<address>
    <p class="color--light-3">Ranayas</p>
    <p class="color--light-3">Kandivali West, Mumbai, Maharashtra, India</p>
    <p class="color--light-3">Email: <a href="mailto:info@ranayas.com">info@ranayas.com</a></p>
    <p class="color--light-3">Phone: <a href="tel:+919820760951">+91 9820760951</a></p>
</address>
HTML
                ,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'refund-return',
                'title' => 'Return & Refund Policy',
                'content' => <<<'HTML'
<p class="text-secondary lh-base">At Ranayas, customer satisfaction is important to us. If you are not completely satisfied with your purchase, please review our Return & Refund Policy below.</p>

<h4 class="mt-4 mb-2"><strong>Return Eligibility</strong></h4>
<p class="text-secondary lh-base">Returns are accepted within <strong>7 days</strong> from the date of delivery. To be eligible for a return:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> The product must be unused and in original condition.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Original packaging, tags, labels, freebies, and accessories must be intact.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> The product should not be damaged, altered, or tampered with.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Non-Returnable Conditions</strong></h4>
<p class="text-secondary lh-base">Returns will not be accepted if:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> The product has been used or damaged.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Original packaging or tags are missing.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Barcode or security seal is tampered with.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Return request is raised after 7 days from delivery.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Free gifts or promotional items are not returned.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Damaged, Defective, or Incorrect Products</strong></h4>
<p class="text-secondary lh-base">If you receive a damaged, defective, or incorrect product, please contact us within <strong>72 hours</strong> of delivery.</p>

<h4 class="mt-4 mb-2"><strong>Return Process</strong></h4>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Email us at <a href="mailto:info@ranayas.com">info@ranayas.com</a> with your Order ID.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Share clear images of the product and packaging.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Our team will review your request.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> If approved, you will be instructed regarding the return process.</li>
</ul>
<p class="text-secondary lh-base">Please ensure the product is returned in original packaging with all accessories and labels intact.</p>

<h4 class="mt-4 mb-2"><strong>Refund Policy</strong></h4>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Refunds are processed after inspection and approval of the returned product.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Shipping charges and return shipping costs may be deducted from the refund amount.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Refunds are generally processed within 10–15 business days.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Cancellation Policy</strong></h4>
<p class="text-secondary lh-base"><strong>Before Shipment:</strong> Orders cancelled before shipment are eligible for a full refund. Refunds are processed within 48–72 business hours.</p>
<p class="text-secondary lh-base"><strong>After Shipment:</strong> If the order has already been shipped, you may refuse delivery or request cancellation by email. Refunds will be processed after the product is returned and inspected. Shipping and return handling charges may be deducted.</p>

<h4 class="mt-4 mb-2"><strong>Loyalty Points & Discount Coupons</strong></h4>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Discount coupons are treated as single-use and may not be restored after cancellation.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Loyalty points used for cancelled orders may be credited back to the customer account.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Refund Support</strong></h4>
<p class="text-secondary lh-base">If you have not received your refund within the expected timeline, please contact us at:</p>
<address>
    <p class="color--light-3">Email: <a href="mailto:info@ranayas.com">info@ranayas.com</a></p>
</address>
HTML
                ,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'shipping',
                'title' => 'Shipping Policy',
                'content' => <<<'HTML'
<p class="text-secondary lh-base">This Shipping Policy applies to purchases made through the Ranayas website and mobile applications available on Android and iOS platforms.</p>

<h4 class="mt-4 mb-2"><strong>Order Processing</strong></h4>
<p class="text-secondary lh-base">All orders are usually processed within <strong>1–2 business days</strong> after successful payment confirmation.</p>
<p class="text-secondary lh-base">Orders are not processed, shipped, or delivered on Sundays, public holidays, or non-working business days.</p>
<p class="text-secondary lh-base">In cases of high order volume, operational delays, natural disruptions, courier delays, or unforeseen circumstances, shipments may be delayed. Customers will be informed via email, SMS, or phone call if there is a significant delay.</p>

<h4 class="mt-4 mb-2"><strong>Shipping Charges</strong></h4>
<p class="text-secondary lh-base">Shipping charges are calculated during checkout based on delivery location, package weight, and shipping method selected. Any additional delivery-related charges imposed by remote locations or courier partners may be applicable.</p>

<h4 class="mt-4 mb-2"><strong>Estimated Delivery Timelines</strong></h4>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Standard Shipping: <strong>5–7 Business Days</strong></li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Expedited Shipping: <strong>2–3 Business Days</strong></li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Express Shipping: <strong>1–2 Business Days</strong></li>
</ul>
<p class="text-secondary lh-base">Delivery timelines are estimated and may vary depending on customer location, weather conditions, courier availability, government restrictions, or other external factors beyond our control.</p>

<h4 class="mt-4 mb-2"><strong>Shipment Confirmation & Tracking</strong></h4>
<p class="text-secondary lh-base">Once your order is shipped, you will receive a shipment confirmation via email, SMS, or WhatsApp containing your tracking details. Tracking details may take up to 24 hours to become active.</p>

<h4 class="mt-4 mb-2"><strong>Customs, Duties, and Taxes</strong></h4>
<p class="text-secondary lh-base">Ranayas is not responsible for any customs duties, taxes, import charges, tariffs, or additional fees imposed during or after shipping. Any such charges levied by local authorities, customs departments, or courier agencies shall be borne solely by the customer.</p>

<h4 class="mt-4 mb-2"><strong>Damaged or Lost Shipments</strong></h4>
<p class="text-secondary lh-base">Ranayas is not responsible for products damaged or lost during shipping transit. Customers are advised to contact the courier company directly for claims. Please retain all packaging materials and damaged products for verification purposes.</p>

<h4 class="mt-4 mb-2"><strong>International Shipping</strong></h4>
<p class="text-secondary lh-base">Currently, we ship only within India.</p>

<hr class="mt-5 mb-4">
<h4 class="mb-3"><strong>Contact Us</strong></h4>
<address>
    <p class="color--light-3">Email: <a href="mailto:info@ranayas.com">info@ranayas.com</a></p>
    <p class="color--light-3">Phone: <a href="tel:+919820760951">+91 9820760951</a></p>
</address>
HTML
                ,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'cancellation',
                'title' => 'Cancellation Policy',
                'content' => <<<'HTML'
<h4 class="mt-4 mb-2"><strong>Before Shipment</strong></h4>
<p class="text-secondary lh-base">Orders cancelled before shipment are eligible for a full refund. Refunds are processed within <strong>48–72 business hours</strong>.</p>

<h4 class="mt-4 mb-2"><strong>After Shipment</strong></h4>
<p class="text-secondary lh-base">If the order has already been shipped:</p>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> You may refuse delivery or request cancellation by email.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Refunds will be processed after the product is returned and inspected.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Shipping and return handling charges may be deducted.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Loyalty Points & Discount Coupons</strong></h4>
<ul class="theme-list-item mb-4">
    <li><i class="fa fa-check" aria-hidden="true"></i> Discount coupons are treated as single-use and may not be restored after cancellation.</li>
    <li><i class="fa fa-check" aria-hidden="true"></i> Loyalty points used for cancelled orders may be credited back to the customer account.</li>
</ul>

<h4 class="mt-4 mb-2"><strong>Refund Support</strong></h4>
<p class="text-secondary lh-base">If you have not received your refund within the expected timeline, please contact us at:</p>
<address>
    <p class="color--light-3">Email: <a href="mailto:info@ranayas.com">info@ranayas.com</a></p>
</address>
HTML
                ,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('policies');
    }
}
