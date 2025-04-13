@extends('hr1.layouts.app')

@section('content')
<div>
    <div class="bg-white rounded-lg p-6 mb-2">
        <h1 class="text-4xl font-bold text-gray-800">Privacy Policy</h1>
    </div>
    <div class="bg-white rounded-lg p-6">
        <p class="text-gray-700 mb-6">
            At <span class="font-semibold">Movers</span>, we value your privacy and are committed to protecting the personal information of our employees and users with the highest standards of data protection. This Privacy Policy comprehensively outlines how we collect, use, process, store, and safeguard your data within our payroll and employee management system in compliance with applicable data protection regulations.
        </p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">1. Information We Collect</h2>
        <p class="text-gray-700 mb-4">To effectively manage our workforce and ensure accurate payroll processing, we collect and maintain the following categories of personal and employment-related information:</p>
        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-6">
            <li><strong>Identification Information:</strong> Full legal name (first, middle, and last), employee ID number, government-issued identification numbers where legally required</li>
            <li><strong>Contact Details:</strong> Primary and secondary email addresses, personal and emergency contact numbers, current residential address</li>
            <li><strong>Demographic Information:</strong> Date of birth, gender, nationality, and marital status for benefits administration</li>
            <li><strong>Employment Details:</strong> Department, position/job title, employment type (full-time, part-time, contract), employment status (active, on leave, terminated), hire date, and employment history</li>
            <li><strong>Compensation Data:</strong> Base salary, hourly wage rates, payment frequency, bank account details for direct deposit, tax withholding information, and benefits enrollment details</li>
            <li><strong>Time and Attendance:</strong> Daily clock-in/out records, leave balances, vacation/sick day usage, overtime hours, and shift schedules</li>
            <li><strong>Performance Data:</strong> Performance reviews, disciplinary records, training completion records, and professional development activities</li>
        </ul>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">2. How We Use Your Information</h2>
        <p class="text-gray-700 mb-4">Your personal data is processed for legitimate business purposes and legal compliance, including but not limited to:</p>
        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-6">
            <li><strong>Payroll Administration:</strong> Accurate calculation of gross and net pay, tax withholdings, social security contributions, and other statutory deductions in accordance with local labor laws</li>
            <li><strong>Benefits Management:</strong> Enrollment in and administration of health insurance, retirement plans, stock options, and other employee benefit programs</li>
            <li><strong>Workforce Management:</strong> Scheduling, attendance tracking, leave management, and workforce planning activities</li>
            <li><strong>Regulatory Compliance:</strong> Meeting legal obligations for tax reporting, social security administration, labor law compliance, and responding to lawful government requests</li>
            <li><strong>System Security:</strong> User authentication, access control, and audit logging to maintain system integrity and prevent unauthorized access</li>
            <li><strong>Business Operations:</strong> Organizational planning, budgeting, reporting, and other legitimate business activities necessary for our operations</li>
        </ul>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">3. Data Sharing and Disclosure</h2>
        <p class="text-gray-700 mb-4">We maintain strict confidentiality of your personal information and disclose it only under the following circumstances:</p>
        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-6">
            <li><strong>Service Providers:</strong> With carefully vetted third-party vendors who provide essential services such as payroll processing, benefits administration, cloud hosting, and IT support, all of whom are contractually bound to maintain confidentiality</li>
            <li><strong>Legal Requirements:</strong> When compelled by law, court order, or government regulation, including to tax authorities, social security agencies, and labor departments</li>
            <li><strong>Corporate Transactions:</strong> In connection with mergers, acquisitions, or reorganizations, with appropriate confidentiality safeguards</li>
            <li><strong>Emergency Situations:</strong> With medical personnel or emergency services when necessary to protect vital interests</li>
        </ul>
        <p class="text-gray-700 mb-6">We never sell employee data to third parties for marketing or commercial purposes unrelated to our business operations.</p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">4. Data Security Measures</h2>
        <p class="text-gray-700 mb-4">
            Movers employs a comprehensive, multi-layered security framework to protect your sensitive information:
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-4">
            <li><strong>Technical Safeguards:</strong> 256-bit SSL encryption for data in transit, AES-256 encryption for data at rest, regular security patching, intrusion detection systems, and advanced firewall protection</li>
            <li><strong>Access Controls:</strong> Role-based access permissions, multi-factor authentication, privileged access management, and comprehensive audit logging of all system access</li>
            <li><strong>Physical Security:</strong> Secure data centers with biometric access controls, 24/7 monitoring, and environmental protections for our server infrastructure</li>
            <li><strong>Organizational Measures:</strong> Mandatory privacy training for all staff, strict confidentiality agreements, and regular security awareness programs</li>
            <li><strong>Continuous Monitoring:</strong> Real-time security monitoring, vulnerability scanning, and penetration testing conducted by qualified security professionals</li>
        </ul>
        <p class="text-gray-700 mb-6">
            While we implement these rigorous security measures using industry best practices and comply with relevant security standards, it's important to understand that no security system is impenetrable. The transmission of information via the internet or methods of electronic storage can never be guaranteed to be 100% secure. Despite our continuous efforts to enhance our security posture, we cannot provide an absolute guarantee against all potential breaches, unauthorized access, or data loss. We commit to promptly investigating and notifying affected individuals of any security incidents in accordance with applicable laws and regulations.
        </p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">5. Data Retention Practices</h2>
        <p class="text-gray-700 mb-6">
            We retain personal data only for as long as necessary to fulfill the purposes outlined in this policy, unless a longer retention period is required or permitted by law. Our retention schedule includes: active employee records maintained throughout employment; payroll records retained for 7 years to meet tax and audit requirements; and archived records securely stored for historical reference. Upon reaching the end of the retention period, data is either securely destroyed using NIST-approved methods or anonymized for statistical analysis. Specific retention periods may vary based on jurisdictional requirements and the nature of the information.
        </p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">6. Your Data Protection Rights</h2>
        <p class="text-gray-700 mb-4">
            As an employee, you have certain rights regarding your personal information, subject to applicable laws and our legitimate business requirements:
        </p>
        <ul class="list-disc list-inside text-gray-700 space-y-1 mb-6">
            <li><strong>Right to Access:</strong> Request a copy of your personal data we maintain, including the purposes of processing and categories of data involved</li>
            <li><strong>Right to Rectification:</strong> Request correction of inaccurate or incomplete personal information</li>
            <li><strong>Right to Erasure:</strong> Request deletion of personal data when no longer necessary for its original purpose, subject to legal retention requirements</li>
            <li><strong>Right to Restriction:</strong> Request temporary limitation of processing under certain circumstances</li>
            <li><strong>Right to Data Portability:</strong> Receive your data in a structured, commonly used format where technically feasible</li>
            <li><strong>Right to Object:</strong> Object to processing based on legitimate interests or for direct marketing purposes</li>
        </ul>
        <p class="text-gray-700 mb-6">
            To exercise these rights, please submit a written request to your HR representative or our Data Protection Officer. We may require verification of your identity before processing certain requests to prevent unauthorized access to sensitive information.
        </p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">7. Policy Updates and Notification</h2>
        <p class="text-gray-700 mb-6">
            This Privacy Policy may be revised periodically to reflect changes in our practices, technology, legal requirements, or business needs. When material changes occur, we will provide advance notice through multiple channels including email notifications, system announcements, and posted notices in common work areas. The "Effective Date" at the bottom of this policy indicates when the latest revisions were implemented. We encourage you to review this policy periodically to stay informed about how we protect your information.
        </p>

        <h2 class="text-2xl font-semibold text-gray-800 mt-10 mb-3">8. Contact Information</h2>
        <p class="text-gray-700 mb-6">
            For all privacy-related inquiries, including questions about this policy, data access requests, or security concerns, please contact our Data Protection Team:
            <br><br>
            <strong>Email:</strong> <a href="mailto:hr1movers129@gmail.com" class="text-blue-600 hover:underline">hr1movers129@gmail.com</a><br>
            <strong>Mail:</strong> Data Protection Officer, Movers Inc., 123 Corporate Drive, Suite 500, Anytown, ST 12345<br>
            <strong>Phone:</strong> (800) 555-COMPANY (extension 2 for HR inquiries)
        </p>

        <p class="text-sm text-gray-500 mt-6">Effective Date: {{ now()->format('F d, Y') }} | Last Reviewed: {{ now()->format('F d, Y') }}</p>
    </div>
</div>
@endsection
