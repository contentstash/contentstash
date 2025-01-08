export async function fetchRoutes() {
  const response = await fetch("/routes");
  return response.json();
}
