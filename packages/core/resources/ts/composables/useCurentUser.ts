export default function () {
  const page = usePage();

  return {
    user: ref<User>({
      ...page.props.user,
    }),
  };
}
