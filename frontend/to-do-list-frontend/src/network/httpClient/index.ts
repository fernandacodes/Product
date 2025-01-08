import type { HttpClient } from "./interface";

export class FetchHttpClient implements HttpClient {
  private baseUrl: string;

  constructor(baseUrl: string) {
    this.baseUrl = baseUrl;
  }

  // Função para pegar o token do localStorage ou outro local
  private getAuthToken(): string | null {
    return localStorage.getItem('authToken'); // Ou de outro lugar onde você armazena o token
  }

  private async request<T>(
    method: string,
    url: string,
    body?: any,
    options: RequestInit = {}
  ): Promise<T> {
    const headers : any = {
      'Content-Type': 'application/json',
      ...options.headers,
    };

    // Adicionando o token no cabeçalho, se existir
    const token = this.getAuthToken();
    if (token) {
      headers['Authorization'] = `Bearer ${token}`;
    }

    const config: RequestInit = {
      method,
      headers,
      ...options,
    };

    if (body) {
      config.body = JSON.stringify(body);
    }

    const response = await fetch(`${this.baseUrl}${url}`, config);

    if (!response.ok) {
      throw new Error(`Request failed with status ${response.status}`);
    }

    return response.json();
  }

  async get<T>(url: string, options: RequestInit = {}): Promise<T> {
    return this.request<T>('GET', url, undefined, options);
  }

  async post<T>(url: string, body: any, options: RequestInit = {}): Promise<T> {
    return this.request<T>('POST', url, body, options);
  }

  async put<T>(url: string, body: any, options: RequestInit = {}): Promise<T> {
    return this.request<T>('PUT', url, body, options);
  }

  async patch<T>(url: string, body: any, options: RequestInit = {}): Promise<T> {
    return this.request<T>('PATCH', url, body, options);
  }

  async delete<T>(url: string, options: RequestInit = {}): Promise<T> {
    return this.request<T>('DELETE', url, undefined, options);
  }
}
