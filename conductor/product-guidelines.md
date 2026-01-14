# Rena Calibration - Product Guidelines

## Tone and Voice
- **Technical Minimalist (Bahasa Indonesia):** The application’s primary language is Bahasa Indonesia. The prose should be professional, precise, and highly functional.
- **Clarity over Fluff:** Avoid conversational filler. Focus on technical accuracy and brevity to ensure technicians and admins can process information quickly in Bahasa Indonesia.
- **Consistent Terminology:** Always use established domain terms (e.g., "Perangkat", "Kalibrasi", "Lokasi") consistently throughout the UI and documentation.

## UI/UX Principles
- **Clarity and Focus:** Prioritize generous whitespace and progressive disclosure. Users should not be overwhelmed by data; only show what is necessary for the current task.
- **Visual Reliability:** Adhere strictly to standardized UI components provided by Filament and Tailwind CSS. This ensures a stable, familiar, and predictable experience across the entire platform.
- **Mobile-First Utility:** Elements must be easily interactable on mobile devices, ensuring field technicians can perform their work without friction.

## Visual Identity and Branding
- **Trust-Based Aesthetic:** Use a palette of professional "trust colors" (deep blues, greys) with high-contrast typography for maximum readability.
- **Asset-Centric Visuals:** Utilize clear iconography and status indicators—such as color-coded badges or "traffic light" systems—to provide immediate visual feedback on device health and compliance.
- **Minimal Branding:** The UI should remain strictly functional. Branding should be subtle (e.g., a simple logo) to keep the focus on the data and workflows.

## Component and Data Naming
- **Domain-Driven Consistency:** Use technical, domain-specific names for all data fields and components consistently in both the code and the user interface. This eliminates ambiguity and reduces cognitive load during development and use.

## Feedback and Notifications
- **Multi-Layered Feedback:**
    - **Routine Actions:** Use non-intrusive toast notifications for successful, low-risk actions.
    - **Critical Events:** Use explicit centered modals for errors or actions requiring confirmation to ensure user acknowledgment.
    - **Data Entry:** Provide immediate, contextual inline feedback next to form fields for validation errors or warnings.
