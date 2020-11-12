import { ref, Ref } from "@vue/runtime-dom";
import useTimeoutFn from "./useTimeoutFn";

type State = "idle" | "pending" | "success" | "error" | "timeout";
type RawFetcher<D> = (...args: any[]) => Promise<D>;
type Result<D, E> = {
  data: Ref<D | undefined>;
  error: Ref<E | undefined>;
  state: Ref<State>;
  run: () => any;
};

export default function useAsyncState<Data = any, Error = any>(
  asyncFn: () => ReturnType<RawFetcher<Data>>,
  options: {
    initial?: boolean;
    timeout?: number;
  } = {}
): Result<Data, Error> {
  const data = ref<Data>();
  const error = ref<Error>();
  const state = ref<State>("idle");

  const [stop, runTimerAgain] = useTimeoutFn(() => {
    state.value = "timeout";
  }, options.timeout || 5000);
  !options.initial && stop();

  function run() {
    state.value = "pending";
    runTimerAgain();

    asyncFn()
      .then(result => {
        if (state.value === "timeout") return;
        stop();
        data.value = result;
        state.value = "success";
      })
      .catch(err => {
        if (state.value === "timeout") return;
        stop();
        error.value = err;
        state.value = "error";
      });
  }
  options.initial && run();

  return {
    data,
    error,
    state,
    run
  };
}
