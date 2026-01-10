## 2024-05-22 - Modernizing Legacy Inputs
**Learning:** Legacy forms often rely solely on placeholders for labels, which fails WCAG accessibility checks. Modernizing these to "Floating Labels" (Bootstrap 5) is a high-impact, low-effort win that provides both accessibility (explicit labels) and a modern aesthetic without requiring layout restructuring.
**Action:** When encountering inputs without labels, prioritize converting them to `form-floating` groups. Ensure the `placeholder` attribute is preserved as it's required for the floating effect.
