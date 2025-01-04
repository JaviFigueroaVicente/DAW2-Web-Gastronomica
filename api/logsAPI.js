export class LogsAPI{ 
    constructor(baseUrl) {
        this.baseUrl = baseUrl;
    }

    async getLogs() {
        try {
            const response = await fetch(`${this.baseUrl}&action=logs`);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Error fetching logs:", error);
            return [];
        }
    }

    async insertLogs(){
        try {
            const response = await fetch(`${this.baseUrl}&action=insert-logs`);
            if (!response.ok) {
                throw new Error(`Error ${response.status}: ${response.statusText}`);
            }
            const data = await response.json();
            return data;
        } catch (error) {
            console.error("Error fetching logs:", error);
            return [];
        }
    }
}