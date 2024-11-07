import corePackageJson from "../../../package.json";

export default function () {
  const page = usePage();

  return {
    getInfo: () => {
      return {
        app: {
          name: page.props.app.name,
        },
        core: {
          version: corePackageJson.version,
        },
      };
    },
  };
}
