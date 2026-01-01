export async function postJson(url, body, { headers = {}, timeoutMs = 1000 } = {}) {
    const controller = new AbortController();
    const timer = setTimeout(() => controller.abort(), timeoutMs);

    try {
        const response = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                ...headers,
            },
            body: JSON.stringify(body),
            signal: controller.signal,
        });

        let data = await response.text();

        try {
            data = JSON.parse(data);
        } catch(e) {
            throw new Error("Response is not Json");
        }

        if(response.ok)
            return data;
        else
            throw new Error(data.error ?? "Undefined error");
    } catch(error) {
        if(error.name == 'AbortError')
            throw new Error(`Request timeout: ${url}`);

        throw error;
    } finally {
        clearTimeout(timer);
    }
}