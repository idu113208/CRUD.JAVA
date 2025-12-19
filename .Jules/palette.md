## 2024-05-24 - Accessibility in Legacy PHP Forms
**Learning:** Legacy PHP forms often rely on implicit label association (if that) or completely separate labels without `for` attributes, breaking screen reader navigation. Adding `autocomplete` attributes is a low-effort, high-impact win for user convenience.
**Action:** Always check `login.php` and `register.php` first for missing `for`/`id` pairs and `autocomplete` attributes.
