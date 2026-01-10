import re
import os
from playwright.sync_api import sync_playwright

def prepare_test_file():
    with open('views/map.php', 'r') as f:
        content = f.read()

    # Mock Google Maps API
    mock_script = """
    <script>
        var google = {
            maps: {
                Map: class { constructor(el, opts) {} },
                Marker: class { constructor(opts) { this.setMap = function() {}; this.addListener = function() {}; } },
                InfoWindow: class { constructor(opts) { this.open = function() {}; } }
            }
        };
    </script>
    """
    # Replace the real API script with mock
    content = re.sub(r'<script src="https://maps.googleapis.com/maps/api/js.*?</script>', mock_script, content, flags=re.DOTALL)

    with open('verification/map.html', 'w') as f:
        f.write(content)
    return os.path.abspath('verification/map.html')

def verify():
    filepath = prepare_test_file()

    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page()

        # Subscribe to console events
        page.on("console", lambda msg: print(f"PAGE LOG: {msg.text}"))
        page.on("pageerror", lambda exc: print(f"PAGE ERROR: {exc}"))

        page.goto(f'file://{filepath}')

        print("Checking for labels...")
        inputs = page.locator('input[type="text"]')
        count = inputs.count()
        labeled_count = 0
        for i in range(count):
            input_el = inputs.nth(i)
            id_val = input_el.get_attribute('id')
            if page.locator(f'label[for="{id_val}"]').count() > 0:
                labeled_count += 1

        print(f"Inputs found: {count}")
        print(f"Labeled inputs found: {labeled_count}")

        if labeled_count < count:
            print("FAIL: Missing labels.")
        else:
            print("PASS: All inputs have labels.")

        print("Checking for loading state...")
        # Mock fetch
        page.evaluate("""
            window.originalFetch = window.fetch;
            window.fetch = (url) => {
                console.log('Mock fetch called for ' + url);
                return new Promise(resolve => {
                    setTimeout(() => {
                        console.log('Mock fetch resolving');
                        resolve({
                            json: () => Promise.resolve({records: []})
                        });
                    }, 2000); // 2 second delay
                });
            };
        """)

        btn = page.locator('#filterBtn')
        if btn.count() == 0:
            print("Button #filterBtn not found!")
            btn = page.locator('button:has-text("Filter")')

        print("Clicking button...")
        btn.click()

        # Check immediately after click
        page.wait_for_timeout(500)

        is_disabled = btn.is_disabled()
        text = btn.inner_text()

        print(f"Button state after click: Disabled={is_disabled}, Text='{text}'")

        if is_disabled or "Memuat" in text:
             print("PASS: Loading state detected.")
        else:
             print("FAIL: No loading state detected.")
             print("Current HTML of button:", btn.inner_html())

        browser.close()

if __name__ == "__main__":
    verify()
