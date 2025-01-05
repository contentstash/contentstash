export {};

declare global {
  type Role = {
    id: string;
    name: string;
    guard_name: "web" | "api" | unknown;
    created_at: string;
    updated_at: string;
    is_system: boolean;
  };
}
