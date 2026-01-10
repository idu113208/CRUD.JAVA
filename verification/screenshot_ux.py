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

    # Also strip PHP tags because we are loading as HTML
    # Simple strip of php tags
    content = re.sub(r'<\?php.*?\?>', '', content, flags=re.DOTALL)

    with open('verification/map.html', 'w') as f:
        f.write(content)
    return os.path.abspath('verification/map.html')

def verify_and_screenshot():
    filepath = prepare_test_file()

    with sync_playwright() as p:
        browser = p.chromium.launch()
        page = browser.new_page()

        page.goto(f'file://{filepath}')

        # Take a screenshot of the initial state (with labels)
        page.screenshot(path="verification/map_labels.png")
        print("Screenshot saved: verification/map_labels.png")

        # Mock fetch
        page.evaluate("""
            window.originalFetch = window.fetch;
            window.fetch = (url) => {
                return new Promise(resolve => {
                    setTimeout(() => {
                        resolve({
                            json: () => Promise.resolve({records: []})
                        });
                    }, 2000); // 2 second delay
                });
            };
        """)

        btn = page.locator('#filterBtn')
        btn.click()

        # Wait a bit for the loading state to render
        page.wait_for_timeout(200)

        # Take a screenshot of the loading state
        page.screenshot(path="verification/map_loading.png")
        print("Screenshot saved: verification/map_loading.png")

        browser.close()

if __name__ == "__main__":
    verify_and_screenshot()
