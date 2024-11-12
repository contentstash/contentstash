import type {
  Router,
  RouteName,
  RouteParams,
  ParameterValue,
  Config,
} from "ziggy-js";
import { route as routeFn } from "ziggy-js";

export default function <T extends RouteName>(
  name?: T,
  params?: RouteParams<T> | ParameterValue | undefined,
  absolute?: boolean,
  config?: Config,
): string | Router {
  // Inject the `route` function with the correct typing
  const route: typeof routeFn | undefined = inject("route");

  if (!route) {
    throw new Error(
      "Route function is not provided. Ensure Ziggy's route function is injected properly.",
    );
  }

  if (name === undefined) {
    return route(undefined, undefined, absolute, config);
  } else {
    return route(name, params as RouteParams<T>, absolute, config);
  }
}
