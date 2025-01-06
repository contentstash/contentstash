export {};

declare global {
  type Permission = {
    id: string;
    name: string;
    guard_name: "web" | "api" | unknown;
    created_at: string;
    updated_at: string;
  };
}
