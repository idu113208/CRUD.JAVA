## 2024-05-24 - Accessibility in Legacy PHP Views
**Learning:** Legacy PHP views often rely on implicit label associations (just placing label next to input) which fails accessibility checks. Explicit `for`/`id` association is crucial.
**Action:** When touching any form in this codebase, always check for and add `for` attributes to labels and `id` attributes to inputs. Also, `autocomplete` attributes are frequently missing and are a low-effort high-value addition.
