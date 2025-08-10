(() => {
  // src/AppReservas/InputMasks.js
  var cpfMask = (value) => {
    return value.replace(/\D/g, "").replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d)/, "$1.$2").replace(/(\d{3})(\d{1,2})/, "$1-$2").replace(/(-\d{2})\d+?$/, "$1");
  };
  var cpfRaw = (value) => {
    return value.replace("-", "").replaceAll(".", "");
  };
  var celularMask = (value) => {
    if (!value)
      return "";
    value = value.replace(/\D/g, "");
    value = value.replace(/(\d{2})(\d)/, "($1) $2");
    value = value.replace(/(\d)(\d{4})$/, "$1-$2");
    return value;
  };
  var celularRaw = (value) => {
    return value.replace("(", "").replace(")", "").replace("-", "").replaceAll(" ", "");
  };

  // src/Hooks/useInput.jsx
  var useInput = (setPassageiros, index, setDone, done) => {
    const [error, setError] = React.useState(false);
    const [value, setValue] = React.useState("");
    const [jaErrou, setJaErrou] = React.useState(false);
    function validaPassageiro(pAtual) {
      const validacaoPassageiro = Object.keys(pAtual).every((key) => {
        if (key === "doc")
          return validarCPF(cpfMask(pAtual[key]));
        else if (key === "telefone")
          return pAtual[key].length >= 14;
        else
          return pAtual[key].length > 2;
      });
      if (validacaoPassageiro)
        setDone(true);
      else
        setDone(false);
    }
    function validate(value2, campo, element) {
      if (campo === "doc") {
        if (validarCPF(value2)) {
          element.classList.add("border-fill");
          element.classList.remove("error");
          setError(false);
        } else {
          element.classList.remove("border-fill");
          element.classList.add("error");
          setError(true);
        }
      } else if (campo === "telefone") {
        if (value2.length >= 14) {
          element.classList.add("border-fill");
          element.classList.remove("error");
          setError(false);
        } else {
          element.classList.remove("border-fill");
          element.classList.add("error");
          setError(true);
        }
      } else if (campo === "nome_completo") {
        if (value2.length >= 3) {
          element.classList.add("border-fill");
          element.classList.remove("error");
          setError(false);
        } else {
          element.classList.remove("border-fill");
          element.classList.add("error");
          setError(true);
        }
      }
      setPassageiros((_passageiros) => {
        let passageiros_a = _passageiros;
        passageiros_a[index][campo] = campo === "doc" ? cpfRaw(value2) : value2;
        validaPassageiro(passageiros_a[index]);
        return passageiros_a;
      });
    }
    function onChange({ target }) {
      if (target.dataset.campo === "doc")
        setValue(cpfMask(target.value));
      else if (target.dataset.campo === "telefone")
        setValue(celularMask(target.value));
      else
        setValue(target.value);
    }
    function onBlur({ target }) {
      console.log(target);
    }
    function validarCPF(cpf) {
      var cpfRegex = /^(?:(\d{3}).(\d{3}).(\d{3})-(\d{2}))$/;
      if (!cpfRegex.test(cpf)) {
        return false;
      }
      var numeros = cpf.match(/\d/g).map(Number);
      var soma = numeros.reduce((acc, cur, idx) => {
        if (idx < 9) {
          return acc + cur * (10 - idx);
        }
        return acc;
      }, 0);
      var resto = soma * 10 % 11;
      if (resto === 10 || resto === 11) {
        resto = 0;
      }
      if (resto !== numeros[9]) {
        return false;
      }
      soma = numeros.reduce((acc, cur, idx) => {
        if (idx < 10) {
          return acc + cur * (11 - idx);
        }
        return acc;
      }, 0);
      resto = soma * 10 % 11;
      if (resto === 10 || resto === 11) {
        resto = 0;
      }
      if (resto !== numeros[10]) {
        return false;
      }
      return true;
    }
    React.useEffect(() => {
      if (index === 0)
        setDone(true);
    }, []);
    return {
      value,
      setValue,
      onChange,
      error,
      onBlur,
      validate: (type, element) => validate(value, type, element)
    };
  };
  var useInput_default = useInput;

  // src/Hooks/useValidations.jsx
  var useValidations = () => {
    function validarCPF(cpf) {
      var cpfRegex = /^(?:(\d{3}).(\d{3}).(\d{3})-(\d{2}))$/;
      if (!cpfRegex.test(cpf)) {
        return false;
      }
      var numeros = cpf.match(/\d/g).map(Number);
      var soma = numeros.reduce((acc, cur, idx) => {
        if (idx < 9) {
          return acc + cur * (10 - idx);
        }
        return acc;
      }, 0);
      var resto = soma * 10 % 11;
      if (resto === 10 || resto === 11) {
        resto = 0;
      }
      if (resto !== numeros[9]) {
        return false;
      }
      soma = numeros.reduce((acc, cur, idx) => {
        if (idx < 10) {
          return acc + cur * (11 - idx);
        }
        return acc;
      }, 0);
      resto = soma * 10 % 11;
      if (resto === 10 || resto === 11) {
        resto = 0;
      }
      if (resto !== numeros[10]) {
        return false;
      }
      return true;
    }
    return {
      validarCPF
    };
  };
  var useValidations_default = useValidations;

  // src/AppReservas/LiPassageiro.jsx
  var LiPassageiro = ({
    passageiro,
    index,
    removePassageiro,
    setPassageiros,
    passageiros
  }) => {
    const [done, setDone] = React.useState(false);
    const nomeInput = useInput_default(setPassageiros, index, setDone, done);
    const telInput = useInput_default(setPassageiros, index, setDone, done);
    const docInput = useInput_default(setPassageiros, index, setDone, done);
    const { validarCPF } = useValidations_default();
    const inputsContainer = React.useRef();
    React.useEffect(() => {
      setTimeout(() => {
        inputsContainer.current && inputsContainer.current.parentElement.classList.add("animate-in");
      }, 100);
    }, []);
    React.useEffect(() => {
      [nomeInput, telInput, docInput].forEach((inp) => {
      });
    }, [passageiros]);
    React.useEffect(() => {
      if (index === 0) {
        const currentUser = JSON.parse(window.sessionStorage.getItem("aer_user"));
        if (currentUser) {
          nomeInput.setValue(currentUser.nome_completo);
          docInput.setValue(cpfMask(currentUser.doc));
          telInput.setValue(celularMask(celularRaw(currentUser.telefone)));
          setPassageiros((_passageiros) => {
            let passageiros_a = _passageiros;
            passageiros_a[0].nome_completo = currentUser.nome_completo;
            passageiros_a[0].doc = currentUser.doc;
            passageiros_a[0].telefone = celularMask(currentUser.telefone);
            const pAtual = passageiros_a[0];
            const validacaoPassageiro = Object.keys(pAtual).every((key) => {
              if (key === "doc")
                return validarCPF(cpfMask(pAtual[key]));
              else if (key === "telefone")
                return pAtual[key].length >= 14;
              else
                return pAtual[key].length > 2;
            });
            if (validacaoPassageiro)
              setDone(true);
            console.log(passageiros_a);
            return passageiros_a;
          });
          inputsContainer.current.querySelectorAll("input").forEach((input) => {
            if (input.dataset.campo === "nome_completo" || input.dataset.campo === "doc") {
              input.classList.add("border-fill");
            }
          });
        }
      }
    }, []);
    return /* @__PURE__ */ React.createElement("li", { className: "passageiro-li", "data-index": index }, /* @__PURE__ */ React.createElement("div", { className: "user-icon" }, /* @__PURE__ */ React.createElement("i", null, /* @__PURE__ */ React.createElement(
      "svg",
      {
        xmlns: "http://www.w3.org/2000/svg",
        width: "40",
        height: "40",
        fill: "currentColor",
        class: "bi bi-person",
        viewBox: "0 0 16 16"
      },
      /* @__PURE__ */ React.createElement("path", { d: "M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6m2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0m4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4m-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10s-3.516.68-4.168 1.332c-.678.678-.83 1.418-.832 1.664z" })
    ))), /* @__PURE__ */ React.createElement(
      "div",
      {
        className: "dados-passageiro",
        ref: inputsContainer,
        "data-index": "Dados do(a) passageiro(a)"
      },
      /* @__PURE__ */ React.createElement(
        "input",
        {
          className: "nome_completo",
          type: "text",
          "data-campo": "nome_completo",
          "data-index": index,
          value: nomeInput.value,
          placeholder: "Nome completo",
          onChange: (e) => nomeInput.onChange(e),
          onBlur: ({ target }) => nomeInput.validate("nome_completo", target)
        }
      ),
      /* @__PURE__ */ React.createElement("div", { className: "d-flex gap-2" }, /* @__PURE__ */ React.createElement("label", null, /* @__PURE__ */ React.createElement("i", null, /* @__PURE__ */ React.createElement(
        "svg",
        {
          xmlns: "http://www.w3.org/2000/svg",
          width: "15",
          height: "14",
          fill: "currentColor",
          className: "bi bi-person-badge",
          viewBox: "0 0 16 16"
        },
        /* @__PURE__ */ React.createElement("path", { d: "M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0" }),
        /* @__PURE__ */ React.createElement("path", { d: "M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492z" })
      )), /* @__PURE__ */ React.createElement(
        "input",
        {
          className: "doc",
          type: "text",
          value: docInput.value,
          placeholder: "CPF",
          "data-campo": "doc",
          maxLength: "14",
          "data-index": index,
          onChange: (e) => docInput.onChange(e),
          onBlur: ({ target }) => docInput.validate("doc", target)
        }
      )), /* @__PURE__ */ React.createElement("label", null, /* @__PURE__ */ React.createElement("i", null, /* @__PURE__ */ React.createElement(
        "svg",
        {
          xmlns: "http://www.w3.org/2000/svg",
          width: "15",
          height: "14",
          fill: "currentColor",
          className: "bi bi-phone-fill",
          viewBox: "0 0 16 16"
        },
        /* @__PURE__ */ React.createElement("path", { d: "M3 2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2zm6 11a1 1 0 1 0-2 0 1 1 0 0 0 2 0" })
      )), /* @__PURE__ */ React.createElement(
        "input",
        {
          className: index === 0 && telInput.value.length > 0 && telInput.value.length < 14 ? "telefone error" : telInput.value.length === 0 ? "telefone" : "telefone border-fill",
          type: "text",
          value: telInput.value,
          placeholder: "Celular",
          maxLength: "15",
          "data-campo": "telefone",
          "data-index": index,
          onChange: (e) => telInput.onChange(e),
          onBlur: ({ target }) => telInput.validate("telefone", target)
        }
      )))
    ), /* @__PURE__ */ React.createElement("div", { className: "icones-passageiro" }, index !== 0 && /* @__PURE__ */ React.createElement("i", { "data-index": index, onClick: removePassageiro }, /* @__PURE__ */ React.createElement(
      "svg",
      {
        xmlns: "http://www.w3.org/2000/svg",
        width: "16",
        height: "16",
        fill: "currentColor",
        className: "bi bi-trash",
        viewBox: "0 0 16 16"
      },
      /* @__PURE__ */ React.createElement("path", { d: "M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" }),
      /* @__PURE__ */ React.createElement("path", { d: "M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" })
    ))));
  };
  var LiPassageiro_default = LiPassageiro;

  // src/AppReservas/Passageiros.jsx
  var Passageiros = ({
    passageiros,
    setPassageiros,
    botaoContinuar,
    embarque,
    horario,
    variacao,
    pID,
    setLoading,
    loading,
    taxa
  }) => {
    const moduloPassageiros = React.useRef();
    const addToCartForm = React.useRef();
    const passageirosHidden = React.useRef();
    const { validarCPF } = useValidations_default();
    const [submitError, setSubmitError] = React.useState(false);
    function handleSubmit(event) {
      event.preventDefault();
      if (!loading) {
        setLoading(true);
        passageirosHidden.current.setAttribute(
          "value",
          JSON.stringify(passageiros)
        );
        setSubmitError(false);
        const validacoes = [];
        passageiros.forEach((pAtual) => {
          if (pAtual) {
            const validacaoPassageiro = Object.keys(pAtual).every((key) => {
              if (key === "doc")
                return validarCPF(cpfMask(pAtual[key]));
              else if (key === "telefone")
                return pAtual[key].length >= 14;
              else
                return pAtual[key].length > 2;
            });
            validacoes.push(validacaoPassageiro);
          }
        });
        const todosDocs = [];
        let docRepetido = false;
        passageiros.forEach((pAtual) => {
          if (pAtual) {
            if (!todosDocs.includes(pAtual.doc))
              todosDocs.push(pAtual.doc);
            else
              docRepetido = true;
          }
        });
        if (validacoes.some((val) => val === false)) {
          validacoes.forEach((val, i) => {
            if (!val) {
              moduloPassageiros.current.querySelectorAll("ul li.passageiro-li")[i].classList.add("error-animate");
            }
            setTimeout(() => {
              moduloPassageiros.current.querySelectorAll("ul li.passageiro-li")[i].classList.remove("error-animate");
            }, 3200);
          });
          setSubmitError("Por favor, verifique os dados informados");
          setLoading(false);
        } else if (docRepetido) {
          setSubmitError("Informe o CPF corretamente para cada passageiro");
          setLoading(false);
        } else if (embarque === null) {
          setSubmitError("Selecione o local de embarque");
          setLoading(false);
        } else if (horario === null) {
          setSubmitError("Selecione um hor\xE1rio");
          setLoading(false);
        } else {
          setPassageiros([...passageiros]);
          event.target.setAttribute("method", "post");
          event.target.setAttribute("action", "");
          event.target.submit();
        }
      }
    }
    function addPassageiro() {
      if (passageiros.filter((p) => p || false).length < variacao.max_qty) {
        setPassageiros([
          ...passageiros,
          { nome_completo: "", doc: "", telefone: "" }
        ]);
      }
    }
    function removePassageiro({ currentTarget }) {
      const passageiros_a = passageiros.map((p, i) => {
        return i !== +currentTarget.dataset.index ? p : false;
      });
      const targetLi = currentTarget.parentElement.parentElement;
      targetLi.classList.remove("animate-in");
      setTimeout(() => {
        setPassageiros(passageiros_a);
      }, 500);
    }
    return /* @__PURE__ */ React.createElement("div", { id: "modulo_passageiros", className: "d-none", ref: moduloPassageiros }, /* @__PURE__ */ React.createElement("p", null, "Passageiros"), /* @__PURE__ */ React.createElement("ul", null, passageiros.map((passageiro, i) => {
      if (passageiro) {
        return /* @__PURE__ */ React.createElement(
          LiPassageiro_default,
          {
            passageiro,
            index: i,
            key: i,
            removePassageiro,
            setPassageiros,
            passageiros
          }
        );
      }
    }), passageiros.filter((p) => p || false).length < variacao.max_qty ? /* @__PURE__ */ React.createElement("li", { className: "add_passageiro_btn", onClick: addPassageiro }, "Adicionar passageiro") : null), /* @__PURE__ */ React.createElement(
      "form",
      {
        className: "variations_form cart",
        onSubmit: handleSubmit,
        encType: "multipart/form-data",
        "data-product-id": pID,
        ref: addToCartForm
      },
      /* @__PURE__ */ React.createElement("input", { type: "hidden", name: "add-to-cart", value: pID }),
      /* @__PURE__ */ React.createElement(
        "input",
        {
          id: "reservaQty",
          type: "number",
          className: "input-text qty text d-none",
          name: "quantity",
          value: passageiros.filter((p) => p || false).length,
          min: "1",
          inputMode: "numeric",
          readOnly: true
        }
      ),
      /* @__PURE__ */ React.createElement("input", { type: "hidden", name: "taxa", value: taxa || "" }),
      /* @__PURE__ */ React.createElement("input", { type: "hidden", name: "embarque", value: embarque || "" }),
      /* @__PURE__ */ React.createElement("input", { type: "hidden", name: "horario", value: horario || "" }),
      /* @__PURE__ */ React.createElement("input", { type: "hidden", name: "passageiros", ref: passageirosHidden }),
      /* @__PURE__ */ React.createElement(
        "input",
        {
          type: "hidden",
          name: "variation_id",
          value: variacao.variation_id || ""
        }
      ),
      botaoContinuar && /* @__PURE__ */ React.createElement(
        "input",
        {
          type: "submit",
          value: loading ? "Aguarde..." : "Continuar",
          className: "single_add_to_cart_button button alt",
          disabled: true
        }
      ),
      submitError ? /* @__PURE__ */ React.createElement("p", { className: "passageiros-error-alert" }, submitError) : null
    ));
  };
  var Passageiros_default = Passageiros;

  // src/AppReservas.jsx
  function AppReservas({ variacoes, embarques, nome, productId }) {
    const [variacaoAtual, setVariacaoAtual] = React.useState(null);
    const [embarque, setEmbarque] = React.useState(null);
    const [taxa, setTaxa] = React.useState(0);
    const [horariosEmbarque, setHorariosEmbarque] = React.useState(null);
    const [horario, setHorario] = React.useState(null);
    const [passageiros, setPassageiros] = React.useState([]);
    const [botaoContinuar, setBotaoContinuar] = React.useState(false);
    const [loading, setLoading] = React.useState(false);
    const [preco, setPreco] = React.useState(false);
    const [precoPadrao, setPrecoPadrao] = React.useState(false);
    const [vagasVar, setVagasVar] = React.useState(null);
    React.useEffect(() => {
      if (variacoes.length === 1 && embarques)
        setVariacaoAtual(variacoes[0]);
    }, []);
    React.useEffect(() => {
      setHorario(null);
      if (!embarque)
        setPreco(false);
      else
        setPreco(precoPadrao + taxa);
    }, [embarque, variacaoAtual]);
    React.useEffect(() => {
      variacaoAtual && setPrecoPadrao(+variacaoAtual.display_regular_price);
      setPreco(false);
      setPassageiros([]);
      setHorariosEmbarque(null);
      const horariosWrapper = document.querySelector(
        ".excursao-details .horarios-wrapper"
      );
      horariosWrapper && horariosWrapper.classList.remove("show-alert");
      setBotaoContinuar(false);
      if (variacaoAtual) {
        const parser = new DOMParser();
        const _html = parser.parseFromString(
          variacaoAtual.availability_html,
          "text/html"
        );
        if (variacaoAtual.availability_html)
          setVagasVar(+_html.querySelector("p").textContent);
        else
          setVagasVar(0);
      }
    }, [variacaoAtual]);
    React.useEffect(() => {
      verificaBotaoContinuar();
    }, [botaoContinuar]);
    function handleSelectEmbarque({ target }) {
      target.parentElement.nextElementSibling.querySelector(".horarios-wrapper").classList.add("show-alert");
      setEmbarque(target.value);
      setTaxa(() => {
        const embObj = embarques.filter(
          (_emb) => _emb.nome_embarque == target.value
        )[0];
        if (embObj.taxa == "unset" || embObj.taxa == "0")
          return 0;
        else
          return +embObj.taxa;
      });
      setHorariosEmbarque(() => {
        const selectedOption = Array.prototype.slice.call(target.children).filter((opt) => opt.selected)[0];
        return selectedOption.dataset.horarios.split(",");
      });
    }
    function handleClickHorario({ target }) {
      setHorario(target.innerText);
      target.parentElement.querySelectorAll("span").forEach((btn) => btn.classList.remove("active"));
      target.classList.add("active");
      target.parentElement.classList.remove("show-alert");
    }
    function handlePassageirosContainer({ target }) {
      const passageirosContainer = document.querySelector("#modulo_passageiros");
      setPassageiros([{ nome_completo: "", doc: "", telefone: "" }]);
      if (passageirosContainer.classList.contains("d-none")) {
        target.setAttribute("disabled", "");
        target.classList.add("d-none");
        passageirosContainer.classList.remove("d-none");
        setTimeout(() => passageirosContainer.classList.add("animate-in"), 120);
      } else {
        target.removeAttribute("disabled");
        passageirosContainer.classList.add("d-none");
        target.classList.remove("d-none");
        passageirosContainer.classList.remove("animate-in");
        setTimeout(() => passageirosContainer.classList.remove("d-none"), 500);
      }
      setBotaoContinuar(!botaoContinuar);
    }
    function verificaBotaoContinuar() {
      if (botaoContinuar) {
        document.querySelector(".single_add_to_cart_button").removeAttribute("disabled");
      }
    }
    return /* @__PURE__ */ React.createElement(React.Fragment, null, /* @__PURE__ */ React.createElement(React.Fragment, null, embarques && variacoes.length > 1 && /* @__PURE__ */ React.createElement(React.Fragment, null, /* @__PURE__ */ React.createElement("div", { className: "datas mb-3" }, /* @__PURE__ */ React.createElement("p", { className: "label mb-1" }, "Datas"), /* @__PURE__ */ React.createElement("div", { className: "datas-badges-wrapper" }, variacoes.map((variacao, i) => {
      let v_dia = variacao.attributes.attribute_dia;
      let v_disponiveis = variacao.availability_html.slice(29).replace("</p>", "");
      let badgeClasses = " ";
      if (variacao.encerrar_vendas) {
        badgeClasses += "badge-venda-encerrada ";
      } else {
        if (v_disponiveis > 0 && v_disponiveis <= 10) {
          badgeClasses += "yellow ";
        } else if (v_disponiveis === "" || v_disponiveis == 0) {
          badgeClasses += "red ";
        }
      }
      return /* @__PURE__ */ React.createElement(
        "span",
        {
          key: v_dia,
          className: "badge-dia disp" + badgeClasses,
          onClick: ({ target }) => {
            document.querySelectorAll(".badge-dia").forEach((b) => b.classList.remove("active"));
            target.classList.add("active");
            setVariacaoAtual(variacoes[i]);
          }
        },
        v_dia.slice(0, -5)
      );
    })))), embarques && variacaoAtual ? /* @__PURE__ */ React.createElement(React.Fragment, null, /* @__PURE__ */ React.createElement("div", { id: "info-container", className: "pt-1" }, /* @__PURE__ */ React.createElement(
      "div",
      {
        key: variacaoAtual.variation_id,
        className: "variacao-info",
        "data-dia": variacaoAtual.attributes.attribute_dia,
        "data-variacao-id": variacaoAtual.variation_id
      },
      !variacaoAtual.encerrar_vendas && vagasVar != 0 && vagasVar < 10 ? /* @__PURE__ */ React.createElement("p", { className: "alerta-vagas ultimos mb-2" }, "Restam ", vagasVar, " vagas") : null,
      !variacaoAtual.encerrar_vendas && !vagasVar ? /* @__PURE__ */ React.createElement("p", { className: "alerta-vagas esgotado" }, "Vagas esgotadas") : null,
      /* @__PURE__ */ React.createElement("div", null, /* @__PURE__ */ React.createElement("p", { className: "label mb-sm-1 mb-0" }, "Dia"), /* @__PURE__ */ React.createElement("p", { className: "info" }, variacaoAtual.attributes.attribute_dia)),
      variacaoAtual.encerrar_vendas ? /* @__PURE__ */ React.createElement("div", { className: "vendas_encerradas_container" }, /* @__PURE__ */ React.createElement("p", null, "Vendas encerradas para essa excurs\xE3o.")) : /* @__PURE__ */ React.createElement("div", { className: "vendas_ativas_container" }, /* @__PURE__ */ React.createElement("div", { className: "modulo_locais_embarque" }, /* @__PURE__ */ React.createElement("p", { className: "label my-sm-2 my-0" }, "Locais de embarque"), embarques.length > 0 ? /* @__PURE__ */ React.createElement(
        "select",
        {
          defaultValue: "none",
          id: "embarque_" + variacaoAtual.attributes.attribute_dia,
          className: "embarque-select",
          "data-variacao-id": variacaoAtual.variation_id,
          onChange: handleSelectEmbarque
        },
        /* @__PURE__ */ React.createElement("option", { value: "none", disabled: true }, "Selecione..."),
        embarques.map((embarque2, i) => {
          const diaAtualOpcao = embarque2.opcoes.filter(
            (_op) => _op.dia === variacaoAtual.attributes.attribute_dia
          )[0];
          const horariosArray = embarque2.opcoes.flatMap(
            (_op) => {
              if (diaAtualOpcao.dia === _op.dia) {
                return _op.horario;
              } else
                return [];
            }
          );
          return diaAtualOpcao.status !== "inativo" ? /* @__PURE__ */ React.createElement(
            "option",
            {
              key: embarque2.nome_embarque,
              value: embarque2.nome_embarque,
              "data-horarios": horariosArray.join()
            },
            embarque2.nome_embarque
          ) : /* @__PURE__ */ React.createElement(
            "option",
            {
              disabled: true,
              key: embarque2.nome_embarque,
              value: embarque2.nome_embarque,
              "data-horarios": []
            },
            embarque2.nome_embarque,
            " (Indispon\xEDvel)"
          );
        })
      ) : /* @__PURE__ */ React.createElement("i", null, "Locais de embarque n\xE3o definidos")), /* @__PURE__ */ React.createElement("div", { className: "module_horarios_embarque" }, /* @__PURE__ */ React.createElement("p", { className: "label mt-3 my-1" }, "Hor\xE1rios"), /* @__PURE__ */ React.createElement(
        "div",
        {
          className: embarque ? "horarios-wrapper show-alert" : "horarios-wrapper"
        },
        horariosEmbarque ? horariosEmbarque.map((horario2) => {
          return /* @__PURE__ */ React.createElement(
            "span",
            {
              key: horario2,
              className: "emb_horario",
              "data-embarque": embarque,
              "data-variacao-id": variacaoAtual.variation_id,
              onClick: handleClickHorario
            },
            horario2
          );
        }) : /* @__PURE__ */ React.createElement("i", null, "Selecione o local de embarque primeiro")
      )), /* @__PURE__ */ React.createElement("div", { className: "modulo_preco mb-3" }, /* @__PURE__ */ React.createElement("p", { className: "label mt-sm-4 mt-3 mb-0" }, "Valor"), preco ? /* @__PURE__ */ React.createElement(React.Fragment, null, /* @__PURE__ */ React.createElement("p", { className: "info" }, "R$ ", preco, ",00"), /* @__PURE__ */ React.createElement("span", null, "por passageiro")) : /* @__PURE__ */ React.createElement("i", null, "Selecione o local de embarque primeiro")), /* @__PURE__ */ React.createElement(
        Passageiros_default,
        {
          passageiros,
          setPassageiros,
          botaoContinuar,
          embarque,
          horario,
          variacao: variacaoAtual,
          pID: productId,
          setLoading,
          loading,
          taxa
        }
      ), variacaoAtual.max_qty !== "" && variacaoAtual.max_qty >= 1 ? /* @__PURE__ */ React.createElement(
        "button",
        {
          className: "btn btn-dark mt-sm-4 mt-2 btn-lg btn-reservar",
          onClick: handlePassageirosContainer
        },
        "Reservar lugar"
      ) : null)
    ))) : null, embarques && variacoes.length > 1 && !variacaoAtual ? /* @__PURE__ */ React.createElement("div", { id: "info-placeholder", className: "my-5" }, /* @__PURE__ */ React.createElement("p", null, variacoes.length > 1 ? "Selecione uma das op\xE7\xF5es acima para ver mais detalhes" : "Aguarde...")) : null, !embarques && !variacaoAtual ? /* @__PURE__ */ React.createElement("p", { class: "mt-5" }, "Mais informa\xE7\xF5es sobre essa excurs\xE3o em breve!") : null));
  }
  var reserva_app_root = document.getElementById("reserva_app");
  addEventListener("DOMContentLoaded", () => {
    if (reserva_app_root) {
      ReactDOM.createRoot(reserva_app_root).render(
        /* @__PURE__ */ React.createElement(
          AppReservas,
          {
            variacoes: JSON.parse(reserva_app_root.dataset.variacoes),
            embarques: JSON.parse(reserva_app_root.dataset.embarques),
            productId: JSON.parse(reserva_app_root.dataset.productId)
          }
        )
      );
    }
  });
})();
